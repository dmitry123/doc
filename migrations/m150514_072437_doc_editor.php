<?php

use yii\db\Migration;

class m150514_072437_doc_editor extends Migration
{
	public function safeUp() {
		$sql = <<< SQL

SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL

SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
