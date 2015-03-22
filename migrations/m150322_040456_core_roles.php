<?php

use yii\db\Migration;

class m150322_040456_core_roles extends Migration {

	public function safeUp() {
		$sql = <<< SQL
		INSERT INTO "core"."role" ("id", "name", "description") VALUES
			('director', 'Директор', 'Директор института'),
			('manager', 'Заведующий кафедрой', 'Может заведовать кафедрой'),
			('student', 'Студент', 'Студент университета'),
			('teacher', 'Преподаватель', 'Преподаватель университета');
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
		DELETE FROM "core"."role" WHERE
			"id" = 'director' OR
			"id" = 'manager' OR
			"id" = 'student' OR
			"id" = 'teacher';
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
