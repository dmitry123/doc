<?php

namespace app\modules\admin\widgets;

use app\core\ActiveRecord;
use app\core\FormModel;
use app\core\Widget;

class TablePanel extends Widget {

	/**
	 * @var ActiveRecord - Instance of table model
	 */
	public $model = null;

	/**
	 * @var FormModel - Instance of form model
	 */
	public $form = null;

	/**
	 * Run widget and return just rendered content
	 * @return string - Just rendered content
	 */
	public function run() {
		if (is_string($this->model)) {
			$this->model = new $this->model();
		}
		if (is_string($this->form)) {
			$this->form = new $this->form();
		}
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