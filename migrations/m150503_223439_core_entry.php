<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_223439_core_entry extends Migration
{
	public function safeUp() {
		$sql = <<< SQL

		DROP SCHEMA IF EXISTS "doc";
		DROP SCHEMA IF EXISTS "core";

		CREATE SCHEMA "core";

		CREATE TABLE "core"."security_key" (
		  "id" SERIAL PRIMARY KEY, -- Идентификатор ключа (чтобы избежать случаного отображение)
		  "key" VARCHAR(128) UNIQUE -- Уникальный ключ безопасности (128 байт)
		);

		CREATE TABLE "core"."user" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "login" VARCHAR(50) NOT NULL UNIQUE, -- Уникальный логин пользователя
		  "password" VARCHAR(123) NOT NULL, -- Хеш сумма пароля DES3
		  "email" VARCHAR(50) DEFAULT NULL UNIQUE, -- Электронный ящик
		  "register_time" TIME DEFAULT now(), -- Время регистрации
		  "register_date" DATE DEFAULT now(), -- Дата регистрации
		  "access_token" VARCHAR(20) DEFAULT NULL, -- Ключ от CSRF атак
		  "security_key_id" INT REFERENCES "core"."security_key" ON DELETE CASCADE DEFAULT NULL -- Ключ безопасности
		);

		CREATE TABLE "core"."role" (
		  "id" VARCHAR(20) PRIMARY KEY, -- Первичный ключ
		  "name" VARCHAR(100), -- Наименование
		  "description" TEXT -- Описание
		);

		CREATE TABLE "core"."privilege" (
		  "id" VARCHAR(10) PRIMARY KEY, -- Первичный ключ
		  "name" VARCHAR(100) NOT NULL, -- Наименование
		  "description" TEXT -- Описание
		);

		CREATE TABLE "core"."privilege_to_role" (
		  "privilege_id" VARCHAR(10) REFERENCES "core"."privilege"("id"), -- Привилегия
		  "role_id" VARCHAR(20) REFERENCES "core"."role"("id") -- Роль
		);

		CREATE TABLE "core"."institute" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "name" VARCHAR(100), -- Наименование института
		  "director_id" INT DEFAULT NULL -- Директор института
		);

		CREATE TABLE "core"."department" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "name" VARCHAR(100) NOT NULL, -- Наименование кафедры
		  "institute_id" INT REFERENCES "core"."institute"("id"), -- Институт кафедры
		  "manager_id" INT DEFAULT NULL -- Менеджер кафедры
		);

		CREATE TABLE "core"."country" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "name" VARCHAR(255) NOT NULL -- Наименование сраны
		);

		CREATE TABLE "core"."region" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "country_id" INT REFERENCES "core"."region" ON DELETE CASCADE, -- Страна, в которой регион находится
		  "name" VARCHAR(255) NOT NULL -- Наименование региона
		);

		CREATE TABLE "core"."city" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "country_id" INT REFERENCES "core"."country"("id") ON DELETE CASCADE, -- Страна, в которой город находится
		  "region_id" INT REFERENCES "core"."region"("id") ON DELETE CASCADE, -- Город, в которой регион находится
		  "name" VARCHAR(255) NOT NULL -- Наименование города
		);

		CREATE TABLE "core"."phone" (
		  "id" SERIAL PRIMARY KEY, -- Превичный ключ
		  "region" INT, -- Код региона
		  "code" INT, -- Код оператора
		  "phone" VARCHAR(30), -- Телефон
		  "type" INT DEFAULT 1 -- Тип телефона
		);

		CREATE TABLE "core"."employee" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "surname" VARCHAR(100) NOT NULL, -- Фамилия
		  "name" VARCHAR(50) NOT NULL, -- Имя
		  "patronymic" VARCHAR(100) NOT NULL, -- Отчество
		  "birthday" DATE DEFAULT NULL, -- Дата рождения
		  "role_id" VARCHAR(20) REFERENCES "core"."role"("id"), -- Роль сотрудника
		  "user_id" INT REFERENCES "core"."user"("id"), -- Пользователь сотрудника
		  "department_id" INT REFERENCES "core"."department"("id"), -- Кафедра сотрудника
		  "phone_id" INT REFERENCES "core"."phone"("id"), -- Телефон
		  "is_validated" INT DEFAULT 0 -- Является ли сотрудника подтвержденным
		);

		ALTER TABLE "core"."department" ADD CONSTRAINT "department_director_id_fkey" FOREIGN KEY ("manager_id") REFERENCES "core"."employee"("id");
		ALTER TABLE "core"."institute" ADD CONSTRAINT "institute_director_id_fkey" FOREIGN KEY ("director_id") REFERENCES "core"."employee"("id");

		CREATE OR REPLACE VIEW "core"."about_employee" AS
		  SELECT "e".*,
			"u"."email" AS "email",
			"u"."login" AS "login",
			"r"."name" AS "role_name",
			"r"."description" AS "role_description"
		  FROM "core"."employee" AS "e"
			JOIN "core"."user" AS "u" ON "u"."id" = "e"."user_id"
			JOIN "core"."role" AS "r" ON "r"."id" = "e"."role_id"
		  WHERE "e"."is_validated" = 1
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL

		DROP VIEW "core"."about_employee";

		ALTER TABLE "core"."institute" DROP CONSTRAINT IF EXISTS "institute_director_id_fkey";
		ALTER TABLE "core"."institute" DROP CONSTRAINT IF EXISTS "department_director_id_fkey";

		DROP TABLE "core"."employee";
		DROP TABLE "core"."phone";
		DROP TABLE "core"."city";
		DROP TABLE "core"."region";
		DROP TABLE "core"."country";
		DROP TABLE "core"."department";
		DROP TABLE "core"."institute";
		DROP TABLE "core"."privilege_to_role";
		DROP TABLE "core"."privilege";
		DROP TABLE "core"."role";
		DROP TABLE "core"."user";
		DROP TABLE "core"."security_key";

		DROP SCHEMA "core";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
