<?php

use yii\db\Schema;
use yii\db\Migration;

class m150408_032809_document_templates extends Migration {

	public function safeUp() {
		$sql = <<< SQL

		DROP TABLE "doc"."template_element" CASCADE;
		DROP TABLE "doc"."template" CASCADE;

		CREATE VIEW "core"."file_template" AS
			SELECT * FROM "core"."file" WHERE "type" = 3;

		CREATE TABLE "core"."file_template_element" (
			"id" SERIAL PRIMARY KEY,
			"type" VARCHAR(20) NOT NULL,
			"file_id" INT REFERENCES "core"."file"("id"),
			"position" INT,
			"node" TEXT
		);
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL

		DROP TABLE "doc"."template_element" CASCADE;
		DROP TABLE "doc"."template" CASCADE;

		CREATE TABLE "doc"."template" (
		  "id" SERIAL PRIMARY KEY,
		  "name" VARCHAR(50) NOT NULL,
		  "document_id" INT REFERENCES "core"."file"("id")
		);

		CREATE TABLE "doc"."template_element" (
		  "id" SERIAL PRIMARY KEY,
		  "type" VARCHAR(10),
		  "template_id" INT REFERENCES "doc"."template"("id"),
		  "position" INT,
		  "node" TEXT
		);
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
