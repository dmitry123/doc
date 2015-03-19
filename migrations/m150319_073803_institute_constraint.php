<?php

use yii\db\Migration;

class m150319_073803_institute_constraint extends Migration {

	public function safeUp() {
		$sql = <<< SQL
			ALTER TABLE "core"."institute" DROP "director_id";
			ALTER TABLE "core"."institute" ADD "director_id" INT REFERENCES "core"."employee"("id") DEFAULT NULL;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
			ALTER TABLE "core"."institute" DROP "director_id";
			ALTER TABLE "core"."institute" ADD "director_id" INT;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
