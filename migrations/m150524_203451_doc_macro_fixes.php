<?php

use app\core\Migration;

class m150524_203451_doc_macro_fixes extends Migration
{
	public function upgrade() {
		return <<< SQL

		DROP TABLE "doc"."macro_to_file";

		ALTER TABLE "doc"."macro" ADD "file_id" INT REFERENCES "doc"."file"("id") ON DELETE CASCADE;
		ALTER TABLE "doc"."macro" ADD "is_static" INT DEFAULT 0;
SQL;
	}

	public function downgrade() {
		return <<< SQL

		ALTER TABLE "doc"."macro" DROP "is_static";
		ALTER TABLE "doc"."macro" DROP "file_id";

        CREATE TABLE "doc"."macro_to_file" (
          "macro_id" INT REFERENCES "doc"."macro"("id") ON DELETE CASCADE, -- Идентификатор макроса
          "file_id" INT REFERENCES "doc"."macro"("id") ON DELETE CASCADE -- Идентификатор файла
        );
SQL;
	}
}
