<?php

use app\core\Migration;

class m150523_223755_doc_file_macro extends Migration
{
	public function upgrade() {
		return <<< SQL

		CREATE TABLE "doc"."file_macro" (
		  "id" SERIAL PRIMARY KEY,
		  "macro_id" INT REFERENCES "doc"."macro"("id") ON DELETE CASCADE,
		  "file_id" INT REFERENCES "doc"."file"("id") ON DELETE CASCADE,
		  "path" TEXT NOT NULL,
		  "name" TEXT NOT NULL
		);
SQL;
	}

	public function downgrade() {
		return <<< SQL
		DROP TABLE "doc"."file_macro";
SQL;
	}
}
