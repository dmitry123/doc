<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_223647_doc_entry extends Migration
{
	public function safeUp() {
		$sql = <<< SQL

		CREATE SCHEMA "doc";

		CREATE TABLE "doc"."file_ext" (
		  "id" SERIAL PRIMARY KEY, -- Первичый ключ
		  "ext" VARCHAR(50) NOT NULL -- Название расширения
		);

		CREATE TABLE "doc"."file_type" (
		  "id" VARCHAR(10) NOT NULL PRIMARY KEY, -- Ключ типа файла
		  "name" VARCHAR(30) NOT NULL, -- Наименование типа файла
		  "description" TEXT -- Описание типа файла
		);

		INSERT INTO "doc"."file_type" ("id", "name", "description") VALUES
		  ('unknown', 'Неизвестный', 'Неизвестный тип файла'),
		  ('document', 'Документ', 'Текстовый документ'),
		  ('table', 'Таблица', 'Таблица'),
		  ('image', 'Изображение', 'Изображение');

		CREATE TABLE "doc"."file_status" (
		  "id" VARCHAR(10) NOT NULL PRIMARY KEY, -- Ключ статуса файла
		  "name" VARCHAR(50) NOT NULL -- Наименование статуса
		);

		INSERT INTO "doc"."file_status" ("id", "name") VALUES
		  ('new', 'Новый'),
		  ('previous', 'Устаревший'),
		  ('current', 'Актуальный'),
		  ('removed', 'Удаленный');

		CREATE TABLE "doc"."file_category" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "name" VARCHAR(100) -- Наименование категории
		);

		CREATE TABLE "doc"."file" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "name" TEXT NOT NULL, -- Наименование файла (без расширения)
		  "path" TEXT NOT NULL, -- Путь к файлу на сервере
		  "file_category_id" INT REFERENCES "doc"."file_category"("id") ON DELETE SET DEFAULT DEFAULT NULL,
		  "employee_id" INT REFERENCES "core"."employee"("id"), -- Сотрудник, загрузивший файл
		  "upload_time" TIME DEFAULT now(), -- Время загрузки файла
		  "upload_date" DATE DEFAULT now(), -- Дата загрузки файла
		  "mime_type" VARCHAR(200) NOT NULL, -- MIME тип файла
		  "parent_id" INT REFERENCES "doc"."file" ON DELETE SET DEFAULT DEFAULT NULL, -- Родительский файл
		  "file_status_id" VARCHAR(10) REFERENCES "doc"."file_status"("id") ON DELETE SET NULL, -- Статус файла
		  "file_type_id" VARCHAR(10) REFERENCES "doc"."file_type"("id") ON DELETE SET NULL, -- Тип файла
		  "file_ext_id" INT REFERENCES "doc"."file_ext"("id") -- Расширение файла
		);

		CREATE TABLE "doc"."file_access" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "mode" SMALLINT DEFAULT -1, -- Уровень доступа RW/R/W
		  -- Левая часть
		  "file_id" INT REFERENCES "doc"."file"("id") ON DELETE CASCADE DEFAULT NULL, -- Файл
		  "file_category_id" INT REFERENCES "doc"."file_category"("id") ON DELETE CASCADE DEFAULT NULL, -- Категория
		  -- Правая часть
		  "privilege_id" VARCHAR(10) REFERENCES "core"."privilege"("id") ON DELETE CASCADE DEFAULT NULL, -- Привилегия
		  "role_id" VARCHAR(20) REFERENCES "core"."role"("id") ON DELETE CASCADE DEFAULT NULL, -- Роль
		  "department_id" INT REFERENCES "core"."department"("id") ON DELETE CASCADE DEFAULT NULL, -- Кафедра
		  "institute_id" INT REFERENCES "core"."institute"("id") ON DELETE CASCADE DEFAULT NULL, -- Институт
		  "employee_id" INT REFERENCES "core"."employee"("id") ON DELETE CASCADE DEFAULT NULL -- Сотрудник
		);

		CREATE OR REPLACE VIEW "doc"."document" AS
		  SELECT * FROM "doc"."file" WHERE "file_type_id" = 'document';

		CREATE OR REPLACE VIEW "doc"."table" AS
		  SELECT * FROM "doc"."file" WHERE "file_type_id" = 'table';

		CREATE OR REPLACE VIEW "doc"."image" AS
		  SELECT * FROM "doc"."file" WHERE "file_type_id" = 'image';

		CREATE OR REPLACE VIEW "doc"."template" AS
		  SELECT * FROM "doc"."file" WHERE "file_type_id" = 'template';

		CREATE TABLE "doc"."file_template_element" (
		  "id" SERIAL PRIMARY KEY, -- Первичный ключ
		  "type" VARCHAR(20) NOT NULL, -- Тип элемента
		  "file_id" INT REFERENCES "doc"."file"("id"), -- Шаблон
		  "position" INT, -- Позиция в файле
		  "node" TEXT DEFAULT NULL -- Узел элемента
		);
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL

		DROP TABLE "doc"."file_template_element";

		DROP VIEW "doc"."template";
		DROP VIEW "doc"."image";
		DROP VIEW "doc"."table";
		DROP VIEW "doc"."document";

		DROP TABLE "doc"."file_access";
		DROP TABLE "doc"."file";
		DROP TABLE "doc"."file_category";
		DROP TABLE "doc"."file_status";
		DROP TABLE "doc"."file_type";
		DROP TABLE "doc"."file_ext";

		DROP SCHEMA "doc";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
