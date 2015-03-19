<?php

use yii\db\Migration;

class m150313_073953_employee_to_role extends Migration {

	public function safeUp() {

		$sql = <<< SQL
			CREATE TABLE "core"."role_to_employee" (
			  "id" SERIAL PRIMARY KEY,
			  "employee_id" INT REFERENCES "core"."employee"("id"),
			  "role_id" VARCHAR(20) REFERENCES "core"."role"("id")
			);
SQL;

		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {

		$sql = <<< SQL
			DROP TABLE "core"."role_to_employee" CASCADE;
SQL;

		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
