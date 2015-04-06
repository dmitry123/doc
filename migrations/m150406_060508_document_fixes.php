<?php

use yii\db\Schema;
use yii\db\Migration;

class m150406_060508_document_fixes extends Migration {

    public function safeUp() {
		$sql = <<< SQL
		DROP TABLE "doc"."access" CASCADE;
		DROP TABLE "doc"."document" CASCADE;
		DROP TABLE "doc"."type" CASCADE;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
    }
    
    public function safeDown() {
		$sql = <<< SQL

		CREATE TABLE "doc"."document" (
		  "id" SERIAL PRIMARY KEY,
		  "name" TEXT NOT NULL,
		  "path" TEXT NOT NULL,
		  "employee_id" INT REFERENCES "core"."employee"("id"),
		  "upload_date" TIMESTAMP DEFAULT now(),
		  "parent_id" INT DEFAULT NULL,
		  "type" INT,
		  "status" INT
		);

		CREATE TABLE "doc"."access" (
			"id" SERIAL PRIMARY KEY,
			"document_id" INT REFERENCES "doc"."document"("id"),
			"role_id" VARCHAR(10) REFERENCES "core"."role"("id")
		);

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
}
