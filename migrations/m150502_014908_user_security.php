<?php

use yii\db\Schema;
use yii\db\Migration;

class m150502_014908_user_security extends Migration
{
	public function safeUp() {
		$sql = <<< SQL
		CREATE TABLE "core"."security_key" (
			"id" SERIAL PRIMARY KEY,
			"key" VARCHAR(128) UNIQUE
		);
		ALTER TABLE "core"."user" ADD "security_key" INT REFERENCES "core"."security_key" DEFAULT NULL
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
		ALTER TABLE "core"."user" DROP "security_key";
		DROP TABLE "core"."security_key"
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
