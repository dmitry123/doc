<?php

namespace app\grids;

use app\core\GridProvider;
use app\models\core\AboutEmployee;

class EmployeeGridProvider extends GridProvider {

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