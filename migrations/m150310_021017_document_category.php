<?php

use yii\db\Migration;

class m150310_021017_document_category extends Migration {

    public function safeUp() {

		$sql = <<< SQL
			CREATE TABLE "doc"."document_category" (
			  "id" SERIAL PRIMARY KEY,
			  "name" VARCHAR(50) NOT NULL,
			  "description" TEXT NOT NULL
			);
			ALTER TABLE "doc"."document" ADD "category_id" INT REFERENCES "doc"."document_category"("id");
SQL;

		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
    
    public function safeDown() {

		$sql = <<< SQL
			ALTER TABLE "doc"."document" DROP "category_id";
			DROP TABLE "doc"."document_category";
SQL;

		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
    }
}
