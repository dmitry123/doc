<?php

namespace app\modules\doc\widgets;

use app\models\MimeType;
use app\widgets\EditableTable;
use yii\helpers\ArrayHelper;

class MimeTypeTable extends EditableTable {

	public $header = [
		"id" => [ "label" => "№", "style" => "width: 150px" ],
		"mime" => [ "label" => "Тип" ],
		"ext" => [ "label" => "Расширение" ]
	];

	public function init() {
		$this->provider = MimeType::model()->getDefaultTableProvider();
	}

	public function getSerializedAttributes($attributes = null, $excepts = []) {
		return parent::getSerializedAttributes($attributes, ArrayHelper::merge($excepts, [
			"header"
		]));
	}
}