<?php

use yii\db\Schema;
use yii\db\Migration;

class m150409_140652_access_rules extends Migration {

	public function safeUp() {
		$sql = <<< SQL
		ALTER TABLE "core"."access" ADD "mode" SMALLINT DEFAULT -1;
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
		ALTER TABLE "core"."access" DROP "mode";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
