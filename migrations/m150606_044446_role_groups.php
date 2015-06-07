<?php


use app\core\Migration;

class m150606_044446_role_groups extends Migration
{
	public function upgrade() {
		return <<< SQL

CREATE TABLE "core"."group" (
  "id" SERIAL PRIMARY KEY,
  "parent_id" INT REFERENCES "core"."group"("id") ON DELETE SET DEFAULT DEFAULT NULL,
  "name" VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE "core"."group_to_privilege" (
  "group_id" INT REFERENCES "core"."group"("id") ON DELETE CASCADE,
  "privilege_id" VARCHAR(10) REFERENCES "core"."privilege"("id") ON DELETE CASCADE
);

CREATE TABLE "core"."access" (
  "id" SERIAL PRIMARY KEY
);

CREATE TABLE "core"."module" (
  "id" VARCHAR(20) PRIMARY KEY,
  "access_id" INT REFERENCES "core"."access"("id") ON DELETE SET DEFAULT DEFAULT NULL,
  "name" VARCHAR(100) NOT NULL,
  "icon" VARCHAR(50) NOT NULL,
  "url" VARCHAR(255) DEFAULT NULL
);

ALTER TABLE "doc"."file" ADD "access_id" INT REFERENCES "core"."access"("id") ON DELETE SET DEFAULT DEFAULT NULL;
SQL;
	}

	public function downgrade() {
		return <<< SQL

ALTER TABLE "doc"."file" DROP "access_id";
DROP TABLE "core"."module";
DROP TABLE "core"."access";
DROP TABLE "core"."group_to_privilege";
DROP TABLE "core"."group";

SQL;
	}
}
