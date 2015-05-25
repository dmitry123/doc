<?php

namespace app\modules\doc\core;

if (!class_exists("CDom")) {
	require __DIR__ . '/Dom.php';
}

use app\models\doc\File;
use app\models\doc\FileExt;
use CDom;
use yii\base\DynamicModel;

class FileCompiler {

	public function __construct($file) {
		$this->_file = $file;
		$this->_html = CDom::fromString(FileManager::getManager()->load($file));
		$this->_list = File::findFileMacro($file->{"id"});
	}

	/**
	 * @param $model DynamicModel
	 * @return $this|string
	 */
	public function compile($model) {
		foreach ($this->_list as $m) {
			$a = $this->_html->find($m["path"]);
			if (!count($a)) {
				continue;
			}
			$element = $a[0];
			$str = $element->html();
			$content = preg_replace('/[\s ]+/', "&nbsp;", $m["content"]);
			$str = preg_replace('/[\s ]+/', "&nbsp;", $str);
			$str = str_replace($content, $model->{$m["id"]}, $str);
			$element->html($str);
		}
		return $this->_html->html();
	}

	private $_list;
	private $_file;
	private $_html;
}