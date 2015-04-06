<?php

namespace app\modules\admin\widgets;

use app\core\FormModel;
use app\core\PostgreSQL;
use app\core\Widget;
use yii\helpers\Inflector;

class TableView extends Widget {

	/**
	 * @var string - Name of table menu title
	 */
	public $title = "Таблицы БД";

	/**
	 * @var array - List with tables to display
	 */
	public $list = [
		"core.department" => [
			"name" => "Кафедры"
		],
		"core.file" => [
			"name" => "Файлы"
		],
		"core.employee" => [
			"name" => "Сотрудники"
		],
		"core.institute" => [
			"name" => "Институты"
		],
		"doc.log" => [
			"name" => "Логи"
		],
		"core.phone" => [
			"name" => "Телефоны"
		],
		"core.privilege" => [
			"name" => "Привилегии"
		],
		"core.role" => [
			"name" => "Роли"
		],
		"core.user" => [
			"name" => "Пользователи"
		]
	];

	/**
	 * @return string
	 */
	public function run() {
		foreach ($this->list as $key => &$table) {
			$this->parseKey($key, $t, $s);
			$table["info"] = PostgreSQL::findColumnNamesAndTypes($t, $s);
			$table["table"] = $t;
			$class = "app\\forms\\".Inflector::id2camel($t, "_")."form";
			if (!class_exists($class)) {
				continue;
			}
			/** @var FormModel $i */
			$i = new $class("table");
			$config = $i->getConfig();
			foreach ($table["info"] as &$info) {
				if (!isset($config[$info["name"]])) {
					continue;
				}
				$info["label"] = $config[$info["name"]]["label"];
			}
		}
		uasort($this->list, function($left, $right) {
			return strcasecmp($left["name"], $right["name"]);
		});
		return $this->render("TableView", [
			"self" => $this
		]);
	}

	/**
	 * Parse table name to fetch table and schema from key
	 * @param string $key - Original key name
	 * @param string $table - Name of table
	 * @param string $schema - Name of schema
	 */
	public function parseKey($key, &$table, &$schema) {
		$s = explode(".", $key);
		if (count($s) > 1) {
			$table = $s[1];
			$schema = $s[0];
		} else {
			$table = $s[0];
			$schema = "public";
		}
	}
}