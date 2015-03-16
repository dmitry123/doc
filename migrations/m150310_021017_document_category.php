<?php

use yii\db\Migration;

class m150310_021017_document_category extends Migration {

    public function safeUp() {

		$sql = <<< HEAD
			CREATE TABLE "document_category" (
			  "id" SERIAL PRIMARY KEY,
			  "name" VARCHAR(50) NOT NULL,
			  "description" TEXT NOT NULL
			);
			ALTER TABLE "document" ADD "category_id" INT REFERENCES "document_category"("id");
HEAD;

		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
    
    public function safeDown() {

		$sql = <<< HEAD
			ALTER TABLE "document" DROP "category_id";
			DROP TABLE "document_category";
HEAD;

		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
    }
}
