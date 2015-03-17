<?php

namespace app\modules\admin\widgets;

use app\core\ActiveRecord;
use app\core\FormModel;
use app\core\Postgres;
use app\core\Widget;
use yii\helpers\Html;
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
		"department" => [
			"name" => "Кафедры"
		],
		"document" => [
			"name" => "Документы"
		],
		"document_category" => [
			"name" => "Категории"
		],
		"employee" => [
			"name" => "Сотрудники"
		],
		"history" => [
			"name" => "История"
		],
		"institute" => [
			"name" => "Институты"
		],
		"log" => [
			"name" => "Логи"
		],
		"phone" => [
			"name" => "Телефоны"
		],
		"privilege" => [
			"name" => "Привилегии"
		],
		"role" => [
			"name" => "Роли"
		],
		"template" => [
			"name" => "Шаблоны"
		],
		"template_element" => [
			"name" => "Элементы"
		],
		"user" => [
			"name" => "Пользователи"
		]
	];

	/**
	 * @return string
	 */
	public function run() {
		foreach ($this->list as $key => &$table) {
			$table["info"] = Postgres::findColumnNamesAndTypes($key);
			$class = "app\\forms\\".Inflector::id2camel($key)."form";
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
}