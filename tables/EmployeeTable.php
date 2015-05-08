<?php

namespace app\tables;

use app\core\Table;
use app\models\core\AboutEmployee;

class EmployeeTable extends Table {

	public $columns = [
		"id" => "#",
		"surname" => "Фамилия",
		"name" => "Имя",
		"role_name" => "Роль",
		"email" => "Почта"
	];

	public $pagination = [
		"pageSize" => 10
	];

	public function getQuery() {
		return AboutEmployee::find();
	}
}