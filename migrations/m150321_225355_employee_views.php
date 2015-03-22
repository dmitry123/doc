<?php

use yii\db\Migration;

class m150321_225355_employee_views extends Migration {

	public function safeUp() {
		$sql = <<< SQL

			CREATE OR REPLACE VIEW "core"."employee_info" AS
				SELECT "e".*,
					"u"."email" AS "email",
					"u"."login" AS "login",
					"r"."name" AS "role_name",
					"r"."description" AS "role_description"
				FROM "core"."employee" AS "e"
				JOIN "core"."user" AS "u" ON "u"."id" = "e"."user_id"
				JOIN "core"."role" AS "r" ON "r"."id" = "e"."role_id";

			CREATE VIEW "core"."teacher" AS
			  SELECT * FROM "core"."employee_info" WHERE
			  	"role_id" = 'teacher' OR
			  	"role_id" = 'director' OR
			  	"role_id" = 'manager';

			CREATE VIEW "core"."student" AS
			  SELECT * FROM "core"."employee_info" WHERE "role_id" = 'student';

			CREATE VIEW "core"."director" AS
			  SELECT * FROM "core"."employee_info" WHERE "role_id" = 'director';

			CREATE VIEW "core"."manager" AS
			  SELECT * FROM "core"."employee_info" WHERE "role_id" = 'manager';

			CREATE VIEW "core"."admin" AS
			  SELECT * FROM "core"."employee_info" WHERE "role_id" = 'admin';
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}

	public function safeDown() {
		$sql = <<< SQL
		DROP VIEW "core"."admin";
		DROP VIEW "core"."manager";
		DROP VIEW "core"."director";
		DROP VIEW "core"."student";
		DROP VIEW "core"."teacher";
		DROP VIEW "core"."employee_info";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
