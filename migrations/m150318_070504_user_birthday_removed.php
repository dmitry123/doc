<?php

use yii\db\Migration;

class m150318_070504_user_birthday_removed extends Migration {

	public function safeUp() {
		$sql = <<< SQL
			ALTER TABLE "employee" DROP "birthday";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
			ALTER TABLE "employee" ADD "birthday" DATE;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
