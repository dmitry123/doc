<?php

use yii\db\Migration;

class m150313_073953_employee_to_role extends Migration {

	public function safeUp() {

		$sql = <<< HEAD
			CREATE TABLE "role_to_employee" (
			  "id" SERIAL PRIMARY KEY,
			  "employee_id" INT REFERENCES "employee"("id"),
			  "role_id" VARCHAR(20) REFERENCES "role"("id")
			);
HEAD;

		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {

		$sql = <<< HEAD
			DROP TABLE "role_to_employee" CASCADE;
HEAD;

		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
