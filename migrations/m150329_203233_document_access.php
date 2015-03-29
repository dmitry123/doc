<?php

use yii\db\Schema;
use yii\db\Migration;

class m150329_203233_document_access extends Migration {

    public function safeUp() {
		$sql = <<< SQL
		CREATE TABLE "doc"."document_access" (
			"id" SERIAL PRIMARY KEY,
			"document_id" INT REFERENCES "doc"."document"("id"),
			"role_id" VARCHAR(10) REFERENCES "core"."role"("id")
		);
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
    }

    public function safeDown() {
		$sql = <<< SQL
		DROP TABLE "doc"."document_access";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
    }
}
