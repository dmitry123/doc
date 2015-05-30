<?php

use yii\db\Migration;

class m150530_040648_employee_faker extends Migration
{
    public function up() {
		$this->generate("director", 10);
		$this->generate("manager", 75);
		$this->generate("student", 1000);
		$this->generate("teacher", 250);
		$this->generate("implementer", 20);
		$this->generate("tester", 15);
    }

	public function generate($role, $count) {
		$faker = \Faker\Factory::create("ru_RU");
		for ($i = 0; $i < $count; $i++) {
			try {
				$user = new \app\models\core\User();
				$user->setAttributes([
					"login" => $faker->userName,
					"password" => '$2y$13$KZ7pljfL9neMY5Bxhpf2g.9jZbgSj7ruDrlZ5aMIXfYhmldwEBgaS',
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
