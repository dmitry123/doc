<?php

use yii\db\Migration;

class m150318_070504_user_birthday_removed extends Migration {

	public function safeUp() {
		$sql = <<< SQL
			ALTER TABLE "core"."employee" DROP "birthday";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
			ALTER TABLE "core"."employee" ADD "birthday" DATE;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
