<?php

namespace app\modules\admin\widgets;

use app\core\ActiveRecord;
use app\core\FormModel;
use app\core\PostgreSQL;
use app\core\Widget;
use yii\helpers\Inflector;

class TableMenu extends Widget {

	/**
	 * @var array - List with tables to display
	 */
	public $list = [
		"doc.file_access" => [
			"label" => "Уровни доступа"
		],
		"core.city" => [
			"label" => "Города"
		],
		"core.country" => [
			"label" => "Страны"
		],
		"core.department" => [
			"label" => "Кафедры"
		],
		"core.employee" => [
			"label" => "Сотрудники"
		],
		"doc.file" => [
			"label" => "Файлы"
		],
		"doc.file_status" => [
			"label" => "Статусы файлов"
		],
		"doc.file_type" => [
			"label" => "Типы файлов"
		],
		"core.institute" => [
			"label" => "Институты"
		],
		"core.mime_type" => [
			"label" => "Расширения файлов"
		],
		"core.phone" => [
			"label" => "Телефоны"
		],
		"core.privilege" => [
			"label" => "Привилегии"
		],
		"core.region" => [
			"label" => "Регионы"
		],
		"core.role" => [
			"label" => "Роли"
		],
		"core.user" => [
			"label" => "Пользователи"
		],
	];

	/**
	 * @return string
	 */
	public function run() {
		foreach ($this->list as $key => &$table) {
			$this->parseKey($key, $t, $s);
			$table["info"] = PostgreSQL::findColumnNamesAndTypes($t, $s);
			$table["schema"] = $s;
			$table["table"] = $t;
			$class = "app\\forms\\".Inflector::id2camel($t, "_")."form";
			$table["model"] = "app\\models\\".Inflector::id2camel($t, "_");
			if (!class_exists($class)) {
				continue;
			}
			/** @var ActiveRecord $i */
			$i = new $class();
			$config = $i->getConfig();
			foreach ($table["info"] as &$info) {
				if (!isset($config[$info["name"]])) {
					continue;
				}
				$info["label"] = $config[$info["name"]]["label"];
			}
		}
		uasort($this->list, function($left, $right) {
			return strcasecmp($left["label"], $right["label"]);
		});
		return $this->render("TableMenu", [
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