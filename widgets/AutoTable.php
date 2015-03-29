<?php

namespace app\widgets;

use app\core\TableProvider;
use app\core\Widget;

class AutoTable extends Widget {

	/**
	 * @var TableProvider - Instance of model, which extends
	 * 	TableProvider class
	 * @see app\widgets\Table::provider
	 */
	public $provider = null;

	/**
	 * Run widget
	 * @return string - Rendered content
	 * @throws \yii\base\ErrorException
	 */
	public function run() {
		$columns = [];
		foreach ($this->provider->getFormModel()->getConfig() as $key => $config) {
			if (isset($config["hidden"]) && $config["hidden"]) {
				continue;
			}
			if (isset($config["type"]) && $config["type"] == "hidden") {
				continue;
			}
			$columns[$key] = [ "width" => ($key == "id" ? "150px" : "auto") ];
		}
		return \app\widgets\Table::widget([
			"controls" => [
				"edit" => [
					"tag" => "span",
					"options" => [
						"class" => "glyphicon glyphicon-pencil pointer",
						"style" => "margin-left: 5px; margin-right: 5px"
					]
				],
				"delete" => [
					"tag" => "span",
					"options" => [
						"class" => "glyphicon glyphicon-remove confirm-delete pointer",
						"style" => "margin-left: 5px; margin-right: 5px; color: #7b1010"
					]
				]
			],
			"columns" => $columns,
			"provider" => $this->provider
		]);
	}
}