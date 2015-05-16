<?php

use app\core\Migration;

class m150516_170406_doc_file_macros extends Migration
{
    public function upgrade() {
        return <<< SQL

        CREATE TABLE "doc"."macro" (
          "id" SERIAL PRIMARY KEY, -- Первичный ключ
          "name" VARCHAR(100) NOT NULL, -- Название макроса
          "type" VARCHAR(10) NOT NULL, -- Тип данных, может
          "value" TEXT DEFAULT NULL -- Значение поля или конфигурация таблица
        );

        CREATE TABLE "doc"."macro_to_file" (
          "macro_id" INT REFERENCES "doc"."macro"("id") ON DELETE CASCADE, -- Идентификатор макроса
          "file_id" INT REFERENCES "doc"."macro"("id") ON DELETE CASCADE -- Идентификатор файла
        );
SQL;
    }

    public function downgrade() {
        return <<< SQL
        DROP TABLE "doc"."macro_to_file";
        DROP TABLE "doc"."macro";
SQL;
    }
}
