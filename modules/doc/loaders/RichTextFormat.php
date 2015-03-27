<?php

namespace app\modules\doc\loaders;

use app\modules\doc\core\Loader;

class RichTextFormat extends Loader {

	/**
	 * @var string - File extension without dot, like
	 * 	OfficeOpenXml, OpenDocumentText, and others
	 */
	public $extension = "rtf";

	/**
	 * Override that method to open document and store
	 * it's handle in self class for next actions
	 * @param string $filename - Name of document to load
	 * @return Loader - Self instance
	 * @throws \Exception
	 */
	public function open($filename) {
		if (($this->content = file_get_contents($filename)) === false) {
			throw new \Exception("Can't load content from file \"$filename\"");
		}
		return $this;
	}

	/**
	 * Override that file to close session with local file
	 * @return Loader - Self instance
	 */
	public function close() {
		return $this;
	}

	/**
	 * Load XML content from document by it's index name
	 * @return string - Document content in XML format
	 * @throws \Exception
	 */
	public function getContent() {
		$text = $this->content;
		# Speeding up via cutting binary data from large rtf's.
		if (strlen($text) > 1024 * 1024) {
			$text = preg_replace("#[\r\n]#", "", $text);
			$text = preg_replace("#[0-9a-f]{128,}#is", "", $text);
		}
		# For Unicode escaping
		$text = str_replace("\\'3f", "?", $text);
		$text = str_replace("\\'3F", "?", $text);
		$document = "";
		$stack = [];
		$j = -1;
		$fonts = [];
		for ($i = 0, $len = strlen($text); $i < $len; $i++) {
			$c = $text[$i];
			// исходя из текущего символа выбираем, что мы с данными будем делать.
			switch ($c) {
				// итак, самый важный ключ "обратный слеш"
				case "\\":
					// читаем следующий символ, чтобы понять, что нам делать дальше
					$nc = $text[$i + 1];
					// Если это другой бэкслеш, или неразрывный пробел, или обязательный
					// дефис, то мы вставляем соответствующие данные в выходной поток
					// (здесь и далее, в поток втавляем только в том случае, если перед
					// нами именно текст, а не шрифтовая вставка, к примеру).
					if ($nc == '\\' && $this->isPlain($stack[$j])) {
						$document .= '\\';
					} else if ($nc == '~' && $this->isPlain($stack[$j])) {
						$document .= ' ';
					} else if ($nc == '_' && $this->isPlain($stack[$j])) {
						$document .= '-';
					} elseif ($nc == '*') {
						$stack[$j]["*"] = true;
					}
					// Если же одинарная кавычка, то мы должны прочитать два следующих
					// символа, которые являются hex-ом символа, который мы должны
					// вставить в наш выходной поток.
					elseif ($nc == "'") {
						$hex = substr($text, $i + 2, 2);
						if ($this->isPlain($stack[$j])) {
							if (!empty($stack[$j]["mac"]) || @$fonts[$stack[$j]["f"]] == 77)
								$document .= $this->fromMacRoman(hexdec($hex));
							elseif (@$stack[$j]["ansicpg"] == "1251" || @$stack[$j]["lang"] == "1029")
								$document .= chr(hexdec($hex));
							else
								$document .= "&#".hexdec($hex).";";
						}
						// Мы прочитали два лишних символа, должны сдвинуть указатель.
						$i += 2;
						// Так перед нами буква, а это значит, что за \ идёт упраляющее слово
						// и возможно некоторый циферный параметр, которые мы должны прочитать.
					} elseif ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
						$word = "";
						$param = null;
						// Начинаем читать символы за бэкслешем.
						for ($k = $i + 1, $m = 0; $k < strlen($text); $k++, $m++) {
							$nc = $text[$k];
							// Если текущий символ буква и до этого не было никаких цифр,
							// то мы всё ещё читаем управляющее слово, если же были цифры,
							// то по документации мы должны остановиться - ключевое слово
							// так или иначе закончилось.
							if ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
								if (empty($param))
									$word .= $nc;
								else
									break;
								// Если перед нами цифра, то начинаем записывать параметр слова.
							} elseif ($nc >= '0' && $nc <= '9')
								$param .= $nc;
							// Минус может быть только перед цифровым параметром, поэтому
							// проверяем параметр на пустоту или в противном случае
							// мы вылезли за пределы слова с параметром.
							elseif ($nc == '-') {
								if (empty($param))
									$param .= $nc;
								else
									break;
								// В любом другом случае - конец.
							} else
								break;
						}
						// Сдвигаем указатель на количество прочитанных нами букв/цифр.
						$i += $m - 1;
						// Начинаем разбираться, что же мы такое начитали. Нас интересует
						// именно управляющее слово.
						$toText = "";
						switch (strtolower($word)) {
							// Если слово "u", то параметр - это десятичное представление
							// unicode-символа, мы должны добавить его в выход.
							// Но мы должны учесть, что за символом может стоять его
							// замена, в случае, если программа просмотрщик не может работать
							// с Unicode, поэтому при наличии \ucN в стеке, мы должны откусить
							// "лишние" N символов из исходного потока.
							case "u":
								$toText .= html_entity_decode("&#x".sprintf("%04x", $param).";");
								$ucDelta = !empty($stack[$j]["uc"]) ? @$stack[$j]["uc"] : 1;
								#$i += $m - 2;
								if ($ucDelta > 0)
									$i += $ucDelta;
								break;
							// Обработаем переводы строк, различные типы пробелов, а также символ
							// табуляции.
							case "par": case "page": case "column": case "line": case "lbr":
							$toText .= "\n";
							break;
							case "emspace": case "enspace": case "qmspace":
							$toText .= " ";
							break;
							case "tab": $toText .= "\t"; break;
							// Добавим вместо соответствующих меток текущие дату или время.
							case "chdate": $toText .= date("m.d.Y"); break;
							case "chdpl": $toText .= date("l, j F Y"); break;
							case "chdpa": $toText .= date("D, j M Y"); break;
							case "chtime": $toText .= date("H:i:s"); break;
							// Заменим некоторые спецсимволы на их html-аналоги.
							case "emdash": $toText .= html_entity_decode("&mdash;"); break;
							case "endash": $toText .= html_entity_decode("&ndash;"); break;
							case "bullet": $toText .= html_entity_decode("&#149;"); break;
							case "lquote": $toText .= html_entity_decode("&lsquo;"); break;
							case "rquote": $toText .= html_entity_decode("&rsquo;"); break;
							case "ldblquote": $toText .= html_entity_decode("&laquo;"); break;
							case "rdblquote": $toText .= html_entity_decode("&raquo;"); break;
							# Skipping binary data...
							case "bin":
								$i += $param;
								break;
							case "fcharset":
								$fonts[@$stack[$j]["f"]] = $param;
								break;
							// Всё остальное добавим в текущий стек управляющих слов. Если у текущего
							// слова нет параметров, то приравляем параметр true.
							default:
								$stack[$j][strtolower($word)] = empty($param) ? true : $param;
								break;
						}
						// Если что-то требуется вывести в выходной поток, то выводим, если это требуется.
						if ($this->isPlain($stack[$j]))
							$document .= $toText;
					} else $document .= " ";
					$i++;
					break;
				// Перед нами символ { - значит открывается новая подгруппа, поэтому мы должны завести
				// новый уровень стека с переносом значений с предыдущих уровней.
				case "{":
					if ($j == -1)
						$stack[++$j] = array();
					else
						array_push($stack, $stack[$j++]);
					break;
				// Закрывающаяся фигурная скобка, удаляем текущий уровень из стека. Группа закончилась.
				case "}":
					array_pop($stack);
					$j--;
					break;
				// Всякие ненужности отбрасываем.
				case "\0": case "\r": case "\f": case "\t": break;
				// Остальное, если требуется, отправляем на выход.
				case "\n":
					$document .= " ";
					break;
				default:
					if ($this->isPlain($stack[$j]))
						$document .= $c;
					break;
			}
		}
		// Возвращаем, что получили.
		return html_entity_decode(iconv("windows-1251", "utf-8", $document), ENT_QUOTES, "UTF-8");
	}

	/**
	 * Mac Roman charset for czech layout
	 * @param string $c - Character
	 * @return string - Result
	 */
	function fromMacRoman($c) {
		$table = [
			0x83 => 0x00c9, 0x84 => 0x00d1, 0x87 => 0x00e1, 0x8e => 0x00e9, 0x92 => 0x00ed,
			0x96 => 0x00f1, 0x97 => 0x00f3, 0x9c => 0x00fa, 0xe7 => 0x00c1, 0xea => 0x00cd,
			0xee => 0x00d3, 0xf2 => 0x00da
		];
		if (isset($table[$c]))
			$c = "&#x".sprintf("%04x", $table[$c]).";";
		return $c;
	}

	/**
	 * Is string has not visible elements
	 * @param string $string - String with text
	 * @return bool - True of false
	 */
	private function isPlain($string) {
		$failAt = ["*",
			"fonttbl",
			"colortbl",
			"datastore",
			"themedata"
		];
		for ($i = 0; $i < count($failAt); $i++) {
			if (!empty($string[$failAt[$i]])) {
				return false;
			}
		}
		return true;
	}

	private $content;
}