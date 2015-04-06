<?php

use yii\db\Schema;
use yii\db\Migration;

class m150405_191709_document_type extends Migration {

	public function safeUp() {
		$sql = <<< SQL
		CREATE TABLE "doc"."type" (
			"id" SERIAL PRIMARY KEY,
			"mime" VARCHAR(100) NOT NULL,
      		"ext" VARCHAR(200) NOT NULL
		);
		ALTER TABLE "doc"."document" DROP "type";
		ALTER TABLE "doc"."document" ADD "type" INT REFERENCES "doc"."type"("id") ON DELETE CASCADE;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
		ALTER TABLE "doc"."document" DROP "type";
		ALTER TABLE "doc"."document" ADD "type" INT;
		DROP TABLE "doc"."type" CASCADE;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
