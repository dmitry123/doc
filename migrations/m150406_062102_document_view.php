<?php

use yii\db\Schema;
use yii\db\Migration;

class m150406_062102_document_view extends Migration {

    public function safeUp() {
		$sql = <<< SQL
		CREATE OR REPLACE VIEW "core"."document" AS SELECT * FROM "core"."file" WHERE "type" = 2;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
    }
    
    public function safeDown() {
		$sql = <<< SQL
		DROP VIEW "core"."document";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
    }
}
