<?php

namespace app\modules\doc\widgets;

use app\modules\doc\core\FileManager;
use app\modules\doc\core\FileWidget;

class Editor_Content_Editor extends FileWidget {

	public $regexp = '/(<p[^>]*>\s*<br[^>]*>\s*<\/p>\s*)+/iu';

	public function run() {
		$content = iconv("Windows-1251", "UTF-8", file_get_contents(
			FileManager::getManager()->getDirectory($this->file->{"path"}), FILE_TEXT
		));
		$content = preg_replace($this->regexp, "<hr>", $content);
		return $this->render("Editor_Content_Editor", [
			"content" => $content,
			"self" => $this,
			"file" => $this->file
		]);
	}
}