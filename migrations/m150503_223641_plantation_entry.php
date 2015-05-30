<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_223641_plantation_entry extends Migration
{
	public function safeUp() {
		$sql = <<< SQL

		INSERT INTO "core"."role" ("id", "name", "description") VALUES
		  ('director', 'Директор', 'Директор института'),
		  ('manager', 'Заведующий кафедрой', 'Может заведовать кафедрой'),
		  ('student', 'Студент', 'Студент университета'),
		  ('teacher', 'Преподаватель', 'Преподаватель университета'),
		  ('implementer', 'Внедренец', 'Может заполнять информацию о ВУЗе'),
		  ('tester', 'Тестровщик', 'Может тестировать систему');

		CREATE VIEW "core"."teacher" AS
		  SELECT * FROM "core"."about_employee" WHERE
			"role_id" = 'teacher' OR
			"role_id" = 'director' OR
			"role_id" = 'manager';

		CREATE VIEW "core"."tester" AS
		  SELECT * FROM "core"."about_employee" WHERE "role_id" = 'tester';

		CREATE VIEW "core"."implementer" AS
		  SELECT * FROM "core"."about_employee" WHERE "role_id" = 'implementer';

		CREATE VIEW "core"."student" AS
		  SELECT * FROM "core"."about_employee" WHERE "role_id" = 'student';

		CREATE VIEW "core"."director" AS
		  SELECT * FROM "core"."about_employee" WHERE "role_id" = 'director';

		CREATE VIEW "core"."manager" AS
		  SELECT * FROM "core"."about_employee" WHERE "role_id" = 'manager';

		CREATE VIEW "core"."admin" AS
		  SELECT * FROM "core"."about_employee" WHERE "role_id" = 'admin';

		CREATE VIEW "core"."super" AS
		  SELECT * FROM "core"."about_employee" WHERE "role_id" = 'super'
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL

		DELETE FROM "core"."employee";

		DELETE FROM "core"."role" WHERE
		  "id" = 'director' OR
		  "id" = 'manager' OR
		  "id" = 'student' OR
		  "id" = 'teacher' OR
		  "id" = 'implementer' OR
		  "id" = 'tester';

		DROP VIEW "core"."super";
		DROP VIEW "core"."admin";
		DROP VIEW "core"."manager";
		DROP VIEW "core"."director";
		DROP VIEW "core"."student";
		DROP VIEW "core"."implementer";
		DROP VIEW "core"."tester";
		DROP VIEW "core"."teacher";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
