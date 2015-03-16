<?php

namespace app\modules\admin\widgets;

use app\core\Widget;
use yii\helpers\Html;

class TableView extends Widget {

	/**
	 * @var string - Name of table menu title
	 */
	public $title = "Таблицы БД";

	/**
	 * @var array - List with tables to display
	 */
	public $list = [
		"user" => [
			"name" => "Пользователи"
		]
	];

	/**
	 * @return string
	 */
	public function run() {
		$this->renderPanel();
	}

	protected function renderPanel() {
		print Html::beginTag("div", [
			"class" => "panel panel-default"
		]);
		print Html::tag("div", $this->title, [
			"class" => "panel-heading"
		]);
		print Html::beginTag("div", [
			"class" => "panel-body",
			"style" => "padding: 0"
		]);
		$this->renderList();
		print Html::endTag("div");
		print Html::endTag("div");
	}

	protected function renderList() {
		print Html::beginTag("ul");
		foreach ($this->list as $key => $table) {
			print Html::tag("li", $table["name"], [
				"class" => "panel panel-default",
				"data-table" => $key
			]);
		}
		print Html::endTag("ul");
	}
}