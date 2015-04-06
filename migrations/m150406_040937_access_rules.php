<?php

use yii\db\Schema;
use yii\db\Migration;

class m150406_040937_access_rules extends Migration {

	public function safeUp() {
		$sql = <<< SQL

		CREATE TABLE "core"."mime_type" (
		  "id" SERIAL PRIMARY KEY,
		  "mime" VARCHAR(100) NOT NULL,
		  "ext" VARCHAR(200) NOT NULL
		);

		CREATE TABLE "core"."file" (
		  "id" SERIAL PRIMARY KEY,
		  "name" TEXT NOT NULL,
		  "path" TEXT NOT NULL,
		  "employee_id" INT REFERENCES "core"."employee"("id"),
		  "upload_time" TIMESTAMP DEFAULT now(),
		  "parent_id" INT REFERENCES "core"."file" ON DELETE SET DEFAULT NULL DEFAULT NULL,
		  "status" INT DEFAULT 1,
		  "type" INT DEFAULT 1,
		  "mime" INT REFERENCES "core"."mime_type"("id")
		);

		CREATE TABLE "core"."access" (
		  "id" SERIAL PRIMARY KEY,
		  "privilege_id" VARCHAR(10) REFERENCES "core"."privilege"("id") DEFAULT NULL,
		  "role_id" VARCHAR(20) REFERENCES "core"."role"("id") DEFAULT NULL,
		  "department_id" INT REFERENCES "core"."department"("id") DEFAULT NULL,
		  "institute_id" INT REFERENCES "core"."institute"("id") DEFAULT NULL,
		  "file_id" INT REFERENCES "core"."file"("id") DEFAULT NULL
		);
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
		DROP TABLE "core"."access";
		DROP TABLE "core"."file";
		DROP TABLE "core"."mime_type";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
