<?php

use yii\db\Migration;

class m150305_142956_database_entry extends Migration {

	public function safeUp() {

		$sql = <<< HERE

			CREATE TABLE "user" (
			  "id" SERIAL PRIMARY KEY,
			  "login" VARCHAR(50) NOT NULL,
			  "password" VARCHAR(123) NOT NULL,
			  "email" VARCHAR(50) DEFAULT '',
			  "register_date" TIMESTAMP DEFAULT now()
			);

			CREATE TABLE "role" (
			  "id" VARCHAR(20) PRIMARY KEY,
			  "name" VARCHAR(100),
			  "description" TEXT
			);

			CREATE TABLE "privilege" (
			  "id" VARCHAR(10) PRIMARY KEY,
			  "name" VARCHAR(100) NOT NULL,
			  "description" TEXT
			);

			CREATE TABLE "privilege_to_role" (
			  "id" SERIAL PRIMARY KEY,
			  "privilege_id" VARCHAR(10) REFERENCES "privilege"("id"),
			  "role_id" VARCHAR(20) REFERENCES "role"("id")
			);

			CREATE TABLE "institute" (
			  "id" SERIAL PRIMARY KEY,
			  "name" VARCHAR(100),
			  "director_id" INT DEFAULT NULL
			);

			CREATE TABLE "department" (
			  "id" SERIAL PRIMARY KEY,
			  "name" VARCHAR(100) NOT NULL,
			  "institute_id" INT REFERENCES "institute"("id"),
			  "manager_id" INT DEFAULT NULL
			);

			CREATE TABLE "phone" (
			  "id" SERIAL PRIMARY KEY,
			  "phone" VARCHAR(30),
			  "type" INT DEFAULT 1
			);

			CREATE TABLE "employee" (
			  "id" SERIAL PRIMARY KEY,
			  "surname" VARCHAR(100) NOT NULL,
			  "name" VARCHAR(50) NOT NULL,
			  "patronymic" VARCHAR(100) NOT NULL,
			  "birthday" DATE NOT NULL,
			  "role_id" VARCHAR(20) REFERENCES "role"("id"),
			  "user_id" INT REFERENCES "user"("id"),
			  "department_id" INT REFERENCES "department"("id"),
			  "phone_id" INT REFERENCES "phone"("id")
			);

			CREATE TABLE "document" (
			  "id" SERIAL PRIMARY KEY,
			  "name" TEXT NOT NULL,
			  "path" TEXT NOT NULL,
			  "employee_id" INT REFERENCES "employee"("id"),
			  "upload_date" TIMESTAMP DEFAULT now(),
			  "parent_id" INT DEFAULT NULL,
			  "type" INT,
			  "status" INT
			);

			CREATE TABLE "history" (
			  "id" SERIAL PRIMARY KEY,
			  "original_id" INT REFERENCES "document"("id"),
			  "current_id" INT REFERENCES "document"("id"),
			  "employee_id" INT REFERENCES "employee"("id"),
			  "date" TIMESTAMP DEFAULT now()
			);

			CREATE TABLE "log" (
			  "id" SERIAL PRIMARY KEY,
			  "user_id" INT REFERENCES "user"("id"),
			  "date" TIMESTAMP DEFAULT now(),
			  "elapsed_time" INT,
			  "type" INT
			);

			CREATE TABLE "template" (
			  "id" SERIAL PRIMARY KEY,
			  "name" VARCHAR(50) NOT NULL,
			  "document_id" INT REFERENCES "document"("id")
			);

			CREATE TABLE "template_element" (
			  "id" SERIAL PRIMARY KEY,
			  "type" VARCHAR(10),
			  "template_id" INT REFERENCES "template"("id"),
			  "position" INT,
			  "node" TEXT
			);
HERE;

		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}

	public function safeDown() {

		$sql = <<< HERE

			DROP TABLE "template_element" CASCADE;
			DROP TABLE "template" CASCADE;
			DROP TABLE "log" CASCADE;
			DROP TABLE "history" CASCADE;
			DROP TABLE "document" CASCADE;
			DROP TABLE "employee" CASCADE;
			DROP TABLE "phone" CASCADE;
			DROP TABLE "department" CASCADE;
			DROP TABLE "institute" CASCADE;
			DROP TABLE "privilege_to_role" CASCADE;
			DROP TABLE "privilege" CASCADE;
			DROP TABLE "role" CASCADE;
			DROP TABLE "user" CASCADE;
HERE;

		foreach (explode(";", $sql) as $s) {
			$this->execute($s);
		}
	}
}