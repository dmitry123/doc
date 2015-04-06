<?php

use yii\db\Schema;
use yii\db\Migration;

class m150328_232230_city_country_region extends Migration {

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

	public function safeUp() {
		$this->load("doc/country.csv", "core.country");
		$this->load("doc/region.csv", "core.region");
		$this->load("doc/city.csv", "core.city");
	}

	public function safeDown() {
		$sql = <<< SQL
		DELETE FROM "core"."city";
		DELETE FROM "core"."region";
		DELETE FROM "core"."country";
SQL;
		foreach (explode(";", $sql) as $query) {
			$this->execute($query);
		}
	}
}
