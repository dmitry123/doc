<?php

use yii\db\Migration;

class m150305_142956_database_entry extends Migration {

	public function safeUp() {
		$sql = <<< SQL

			CREATE SCHEMA core

			CREATE TABLE "core"."user" (
			  "id" SERIAL PRIMARY KEY,
			  "login" VARCHAR(50) NOT NULL,
			  "password" VARCHAR(123) NOT NULL,
			  "email" VARCHAR(50) DEFAULT '',
			  "register_date" TIMESTAMP DEFAULT now()
			);

			CREATE TABLE "core"."role" (
			  "id" VARCHAR(20) PRIMARY KEY,
			  "name" VARCHAR(100),
			  "description" TEXT
			);

			CREATE TABLE "core"."privilege" (
			  "id" VARCHAR(10) PRIMARY KEY,
			  "name" VARCHAR(100) NOT NULL,
			  "description" TEXT
			);

			CREATE TABLE "core"."privilege_to_role" (
			  "id" SERIAL PRIMARY KEY,
			  "privilege_id" VARCHAR(10) REFERENCES "core"."privilege"("id"),
			  "role_id" VARCHAR(20) REFERENCES "core"."role"("id")
			);

			CREATE TABLE "core"."institute" (
			  "id" SERIAL PRIMARY KEY,
			  "name" VARCHAR(100),
			  "director_id" INT DEFAULT NULL
			);

			CREATE TABLE "core"."department" (
			  "id" SERIAL PRIMARY KEY,
			  "name" VARCHAR(100) NOT NULL,
			  "institute_id" INT REFERENCES "core"."institute"("id"),
			  "manager_id" INT DEFAULT NULL
			);

			CREATE TABLE "core"."phone" (
			  "id" SERIAL PRIMARY KEY,
			  "phone" VARCHAR(30),
			  "type" INT DEFAULT 1
			);

			CREATE TABLE "core"."employee" (
			  "id" SERIAL PRIMARY KEY,
			  "surname" VARCHAR(100) NOT NULL,
			  "name" VARCHAR(50) NOT NULL,
			  "patronymic" VARCHAR(100) NOT NULL,
			  "birthday" DATE NOT NULL,
			  "role_id" VARCHAR(20) REFERENCES "core"."role"("id"),
			  "user_id" INT REFERENCES "core"."user"("id"),
			  "department_id" INT REFERENCES "core"."department"("id"),
			  "phone_id" INT REFERENCES "core"."phone"("id")
			);

			CREATE SCHEMA doc;

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

			CREATE TABLE "doc"."history" (
			  "id" SERIAL PRIMARY KEY,
			  "original_id" INT REFERENCES "doc"."document"("id"),
			  "current_id" INT REFERENCES "doc"."document"("id"),
			  "employee_id" INT REFERENCES "core"."employee"("id"),
			  "date" TIMESTAMP DEFAULT now()
			);

			CREATE TABLE "doc"."log" (
			  "id" SERIAL PRIMARY KEY,
			  "user_id" INT REFERENCES "core"."user"("id"),
			  "date" TIMESTAMP DEFAULT now(),
			  "elapsed_time" INT,
			  "type" INT
			);

			CREATE TABLE "doc"."template" (
			  "id" SERIAL PRIMARY KEY,
			  "name" VARCHAR(50) NOT NULL,
			  "document_id" INT REFERENCES "doc"."document"("id")
			);

			CREATE TABLE "doc"."template_element" (
			  "id" SERIAL PRIMARY KEY,
			  "type" VARCHAR(10),
			  "template_id" INT REFERENCES "doc"."template"("id"),
			  "position" INT,
			  "node" TEXT
			);
SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
			DROP TABLE "doc"."template_element" CASCADE;
			DROP TABLE "doc"."template" CASCADE;
			DROP TABLE "doc"."log" CASCADE;
			DROP TABLE "doc"."history" CASCADE;
			DROP TABLE "doc"."document" CASCADE;
			DROP SCHEMA "doc";
			DROP TABLE "core"."employee" CASCADE;
			DROP TABLE "core"."phone" CASCADE;
			DROP TABLE "core"."department" CASCADE;
			DROP TABLE "core"."institute" CASCADE;
			DROP TABLE "core"."privilege_to_role" CASCADE;
			DROP TABLE "core"."privilege" CASCADE;
			DROP TABLE "core"."role" CASCADE;
			DROP TABLE "core"."user" CASCADE;
			DROP SCHEMA "core";
SQL;
		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}
}