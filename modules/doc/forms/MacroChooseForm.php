<?php

namespace app\modules\doc\forms;

use app\core\FormModel;
use app\models\doc\Macro;
use yii\helpers\ArrayHelper;

class MacroChooseForm extends FormModel {

	public $type;
	public $macro;

	public function rules() {
		return ArrayHelper::merge(parent::rules(), [
			[ [ "type", "macro" ], "required" ]
		]);
	}

	public function attributeLabels() {
		return parent::attributeLabels() + [
			"macro" => "Макрос"
		];
	}

	public function createActiveRecord() {
		return new Macro();
	}
}