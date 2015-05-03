<?php

namespace app\modules\doc\widgets;

use app\models\FileType;
use app\widgets\EditableTable;
use yii\helpers\ArrayHelper;

class FileTypeTable extends EditableTable {

	public $header = [
		"id" => [ "label" => "№", "style" => "width: 150px" ],
		"name" => [ "label" => "Наименование" ]
	];

	public function init() {
		$this->provider = FileType::model()->getDefaultTableProvider();
	}

	public function getSerializedAttributes($attributes = null, $excepts = []) {
		return parent::getSerializedAttributes($attributes, ArrayHelper::merge($excepts, [
				"header"
			]));
	}
}