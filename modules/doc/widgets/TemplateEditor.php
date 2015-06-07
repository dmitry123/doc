<?php

namespace app\modules\doc\widgets;

use app\models\doc\File;
use app\modules\doc\core\FileManager;
use app\modules\doc\core\FileWidget;

class TemplateEditor extends FileWidget {

	public $regexp = '/(<p[^>]*>\s*<br[^>]*>\s*<\/p>\s*)+/iu';

	public function run() {
		$content = FileManager::getManager()->load($this->file);
//		$content = preg_replace($this->regexp, "<hr>", $content);
		return $this->render("TemplateEditor", [
			"content" => $content,
			"macro" => File::findFileMacro($this->file->{"id"}),
			"file" => $this->file,
			"self" => $this,
		]);
	}
}