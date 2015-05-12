<?php

namespace app\modules\doc\widgets;

use app\core\Widget;
use app\models\doc\File;
use app\modules\doc\core\FileUploader;
use yii\base\Exception;
use yii\helpers\Html;

class Editor_TemplateContent_Editor extends Widget {

	public $file = null;

	public $regexp = '/(<p[^>]*>\s*<br[^>]*>\s*<\/p>\s*)+/i';

	public function run() {
		if (empty($this->file)) {
			throw new Exception("File's identification number mustn't be empty");
		} else if (!$file = File::findOne([ "id" => $this->file ])) {
			throw new Exception("Can't resolve file with \"$this->file\" identification number");
		} else if ($file->{"file_type_id"} != "template") {
			throw new Exception("Можно редактировать только шаблоны файлов");
		}
		$content = iconv("Windows-1251", "UTF-8", file_get_contents(
			FileUploader::getUploader()->getDirectory($file->{"path"}), FILE_TEXT
		));
		$content = preg_replace($this->regexp, Html::tag("hr"), $content);
		return $this->render("Editor_TemplateContent_Editor", [
			"content" => $content,
			"self" => $this,
			"file" => $file
		]);
	}
}