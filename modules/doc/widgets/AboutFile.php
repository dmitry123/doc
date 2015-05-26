<?php

namespace app\modules\doc\widgets;

use app\core\Widget;
use app\models\doc\File;
use yii\base\Exception;
use yii\helpers\Html;

class AboutFile extends Widget {

	/**
	 * @var File|int file's identification number, which
	 * 	information about u'd like to load
	 */
	public $file = null;

	/**
	 * @var array with columns for file model, which
	 * 	should be displayed
	 */
	public $columns = [
		"file/name" => "Наименование файла", "file/upload_date", "file/upload_time"
	];

	/**
	 * Run widget and return it's just rendered content
	 * @return string just rendered content
	 * @throws Exception
	 */
	public function run() {
		if (empty($this->file)) {
			return Html::tag("h4", "Файл не выбран", [
				"class" => "text-center"
			]);
		} else if (!$this->file = File::findOne([ "id" => $this->file ])) {
			throw new Exception("Unresolved file identification number");
		}
		$labels = $this->file->attributeLabels();
		$columns = [];
		foreach ($this->columns as $key => $c) {
			if (is_int($key)) {
				$key = $c;
			}
			if (count($s = explode("/", $key)) != 2) {;
				$field = "file";
				$id = $s[0];
			} else {
				$field = $s[0];
				$id = $s[1];
			}
			if ($key == $c && isset($labels[$id])) {
				$c = $labels[$id];
			}
			$columns[$key] = [
				"label" => $c,
				"id" => $id,
				"field" => $field
			];
		}
		return $this->render("AboutFile", [
			"ext" => $this->file->findExt(),
			"employee" => $this->file->findEmployee(),
			"file" => $this->file,
			"status" => $this->file->findStatus(),
			"type" => $this->file->findType(),
			"columns" => $columns
		]);
	}
}