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

		CREATE TABLE "core"."file_type" (
		  "id" VARCHAR(10) NOT NULL PRIMARY KEY,
		  "name" VARCHAR(30) NOT NULL,
		  "description" TEXT
		);

		INSERT INTO "core"."file_type" (id, name, description) VALUES
			('unknown', 'Неизвестный', 'Неизвестный тип файла'),
			('document', 'Документ', 'Тип документа текста'),
			('table', 'Таблица', 'Тип документа таблицы'),
			('image', 'Изображение', 'Тип документа изображения');

		CREATE TABLE "core"."file_status" (
			"id" VARCHAR(10) NOT NULL PRIMARY KEY,
			"name" VARCHAR(50) NOT NULL
		);

		INSERT INTO "core"."file_status" (id, name) VALUES
			('new', 'Новый'),
			('previous', 'Устаревший'),
			('current', 'Актуальный'),
			('removed', 'Удаленный');

		CREATE TABLE "core"."file" (
		  "id" SERIAL PRIMARY KEY,
		  "name" TEXT NOT NULL,
		  "path" TEXT NOT NULL,
		  "employee_id" INT REFERENCES "core"."employee"("id"),
		  "upload_time" TIME DEFAULT now(),
		  "upload_date" DATE DEFAULT now(),
		  "parent_id" INT REFERENCES "core"."file" ON DELETE SET DEFAULT NULL DEFAULT NULL,
		  "file_status_id" VARCHAR(10) REFERENCES "core"."file_status"("id") ON DELETE SET NULL,
		  "file_type_id" VARCHAR(10) REFERENCES "core"."file_type"("id") ON DELETE SET NULL,
		  "mime_type_id" INT REFERENCES "core"."mime_type"("id")
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
		DROP TABLE "core"."file" CASCADE;
		DROP TABLE "core"."file_type";
		DROP TABLE "core"."file_status";
		DROP TABLE "core"."mime_type";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
