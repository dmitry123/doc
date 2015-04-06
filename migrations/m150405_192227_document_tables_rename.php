<?php

use yii\db\Schema;
use yii\db\Migration;

class m150405_192227_document_tables_rename extends Migration {

	public function safeUp() {
		$sql = <<< SQL
		ALTER TABLE "doc"."document_access" RENAME TO "access";
		ALTER TABLE "doc"."document_category" RENAME TO "category";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
		ALTER TABLE "doc"."access" RENAME TO "document_access";
		ALTER TABLE "doc"."category" RENAME TO "document_category";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
