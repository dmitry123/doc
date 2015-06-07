<?php

namespace app\commands;

use yii\console\Controller;

class FakeController extends Controller {

	public $password = 'fake123';

	public function actionEmployee() {
		$this->fakeEmployee("director", 4);
		$this->fakeEmployee("manager", 15);
		$this->fakeEmployee("student", 5000);
		$this->fakeEmployee("teacher", 300);
		$this->fakeEmployee("implementer", 100);
		$this->fakeEmployee("tester", 2);
	}

	private function fakeEmployee($role, $count) {
		$faker = \Faker\Factory::create("ru_RU");
		$hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
		for ($i = 0; $i < $count; $i++) {
			try {
				$user = new \app\models\core\User();
				$user->setAttributes([
					"login" => $faker->userName,
					"password" => $hash,
					"email" => $faker->email
				], false);
				$user->save();
				$employee = new \app\models\core\Employee();
				$employee->setAttributes([
					"surname" => $faker->lastName,
					"name" => $faker->firstName,
					"patronymic" => $faker->{"middleName"},
					"birthday" => $faker->dateTimeThisCentury->format("Y-m-d"),
					"role_id" => $role,
					"user_id" => $user->getAttribute("id"),
					"department_id" => null,
					"phone_id" => null,
					"is_validated" => 1
				], false);
				$employee->save();
			} catch (\Exception $e) {
			}
		}
	}
}