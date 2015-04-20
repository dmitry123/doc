<?php

namespace app\modules\admin\widgets;

use app\core\ActiveRecord;
use app\core\FormModel;
use app\core\Widget;

class TablePanel extends Widget {

	/**
	 * @var ActiveRecord - Instance of table model
	 */
	public $model;

	/**
	 * @var FormModel - Instance of form model
	 */
	public $form;

	/**
	 * Run widget and return just rendered content
	 * @return string - Just rendered content
	 */
	public function run() {
		if (!empty($this->form)) {
			return $this->render("TablePanel", [
				"self" => $this
			]);
		} else {
			return \yii\helpers\Html::tag("h4", "Таблица не выбрана", [
				"class" => "text-center"
			]);
		}
	}
}