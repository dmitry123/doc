<?php

use yii\db\Schema;
use yii\db\Migration;

class m150406_053142_new_cladr_tables extends Migration {

	public function execute($sql, $params = []) {
		$sql = trim($sql);
		try {
			if (!empty($sql)) {
				parent::execute($sql, $params);
			}
		} catch (\Exception $e) {
			print "\"$sql\"";
			throw $e;
		}
	}

	public function safeUp() {
		$sql = <<< SQL

		DROP TABLE "core"."city" CASCADE;
		DROP TABLE "core"."region" CASCADE;
		DROP TABLE "core"."country" CASCADE;

		CREATE TABLE "core"."country" (
			"id" SERIAL PRIMARY KEY,
			"name" VARCHAR(255) NOT NULL
		);

		CREATE TABLE "core"."region" (
			"id" SERIAL PRIMARY KEY,
			"name" VARCHAR(255) NOT NULL,
			"country_id" INT REFERENCES "core"."country"("id")
		);

		CREATE TABLE "core"."city" (
			"id" SERIAL PRIMARY KEY,
			"name" VARCHAR(255) NOT NULL,
			"country_id" INT REFERENCES "core"."country"("id"),
			"region_id" INT REFERENCES "core"."region"("id")
		);
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
		$f = function($file) {
			$sql = file_get_contents($file);
			foreach (explode(";", $sql) as $query) {
				$this->execute(preg_replace("/[^a-zA-Z0-9].*INSERT/", "INSERT", $query));
			}
		};
		try {
			$f("doc/cladr_country.sql");
			$f("doc/cladr_region.sql");
			$f("doc/cladr_city.sql");
		} catch (\Exception $e) {
			file_put_contents("error.txt", $e->getMessage());
			throw $e;
		}
    }
    
    public function safeDown() {
		$sql = <<< SQL

		DROP TABLE "core"."city" CASCADE;
		DROP TABLE "core"."region" CASCADE;
		DROP TABLE "core"."country" CASCADE;

		CREATE TABLE "core"."country" (
			"id" INT PRIMARY KEY,
			"name" VARCHAR(255) NOT NULL,
			"city_id" INT
		);

		CREATE TABLE "core"."region" (
			"id" INT PRIMARY KEY,
			"country_id" INT,
			"name" VARCHAR(255) NOT NULL,
			"city_id" INT
		);

		CREATE TABLE "core"."city" (
			"id" INT PRIMARY KEY,
			"country_id" INT,
			"region_id" INT,
			"name" VARCHAR(255) NOT NULL
		);
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
		$this->load("doc/country.csv", "core.country");
		$this->load("doc/region.csv", "core.region");
		$this->load("doc/city.csv", "core.city");
    }

	public function load($filename, $table) {
		if (($handle = fopen($filename, "rt")) == false) {
			throw new \yii\base\Exception("Can't resolve filename \"{$filename}\"");
		}
		if (($header = fgets($handle)) === false) {
			throw new \yii\base\Exception("Invalid CVS file's header");
		} else {
			$header = str_replace(";", ",", $header);
		}
		while (($line = fgets($handle)) !== false) {
			$line = str_replace("\"", "'", str_replace(";", ",", $line));
			$line = preg_replace("/'(\\d+)'/", "$1", $line);
			$line = iconv("Windows-1251", "UTF-8", $line);
			$this->execute("INSERT INTO $table ($header) VALUES ($line)");
		}
	}
}
