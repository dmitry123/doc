<?php

use yii\db\Schema;
use yii\db\Migration;

class m150319_080513_role_to_employee_drop extends Migration {

	public function safeUp() {
		$sql = <<< SQL
			DROP TABLE "core"."role_to_employee";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
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
}
