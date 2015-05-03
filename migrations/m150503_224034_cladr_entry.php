<?php

use yii\db\Schema;
use yii\db\Migration;

class m150503_224034_cladr_entry extends Migration
{
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
			file_put_contents("runtime/logs/migrations.txt", $e->getMessage());
			throw $e;
		}
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
