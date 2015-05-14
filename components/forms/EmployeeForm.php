<?php

namespace app\components\forms;

use app\components\FormModel;
use app\models\core\Employee;

class EmployeeForm extends FormModel {

	public $surname;
	public $name;
	public $patronymic;

	public function rules() {
		return $this->getActiveRecord()->rules() + [
		];
	}

	public function createActiveRecord() {
		return Employee::createWithModel($this);
	}
}