<?php

use app\core\Migration;

class m150515_175031_doc_file_ext_fix extends Migration {

    public function upgrade() {
        return <<< SQL
        ALTER TABLE "doc"."file_ext" ADD "file_type_id" VARCHAR(10) REFERENCES "doc"."file_type"("id") ON DELETE CASCADE
SQL;
    }

    public function downgrade() {
        return <<< SQL
        ALTER TABLE "doc"."file_ext" DROP "file_type_id"
SQL;
    }
}
