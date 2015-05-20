<?php


use app\core\Migration;

class m150520_032543_doc_macro_columns extends Migration
{

	public function upgrade() {
		return <<< SQL

		CREATE TABLE "doc"."macro_column" (
			"id" SERIAL PRIMARY KEY,
			"column" VARCHAR(50) NOT NULL,
			"macro_id" INT REFERENCES "doc"."macro"("id")
		);

		ALTER TABLE "doc"."macro" ADD "table" VARCHAR(100) DEFAULT NULL;
SQL;
	}

	public function downgrade() {
		return <<< SQL

		ALTER TABLE "doc"."macro" DROP "table";
		DROP TABLE "doc"."macro_column";
SQL;
	}
}
