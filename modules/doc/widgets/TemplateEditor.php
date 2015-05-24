<?php

namespace app\modules\doc\widgets;

use app\models\doc\File;
use app\modules\doc\core\FileManager;
use app\modules\doc\core\FileWidget;

class TemplateEditor extends FileWidget {

	public $regexp = '/(<p[^>]*>\s*<br[^>]*>\s*<\/p>\s*)+/iu';

	public function run() {
		$content = iconv("Windows-1251", "UTF-8", file_get_contents(
			FileManager::getManager()->getDirectory($this->file->{"path"}), FILE_TEXT
		));
//		$content = preg_replace($this->regexp, "<hr>", $content);
		return $this->render("TemplateEditor", [
			"content" => $content,
			"macro" => File::findFileMacro($this->file->{"id"}),
			"file" => $this->file,
			"self" => $this,
		]);
	}
}