<?php

namespace app\widgets;

use app\core\DropDown;
use app\core\FieldCollection;
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
	 * @var array - Array with control configuration, same
	 * 	as [Table::controls]
	 * @see app\widgets\Table::$controls
	 */
	public $controls = [
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
	];

	/**
	 * Run widget
	 * @return string - Rendered content
	 * @throws \yii\base\ErrorException
	 */
	public function run() {
		$columns = [];
		foreach ($this->provider->getFormModel()->getConfig() as $key => $config) {
			if (isset($config["hidden"]) && $config["hidden"] || isset($config["type"]) && $config["type"] == "hidden") {
				continue;
			} else if (in_array($key, $this->provider->keys) || in_array("*", $this->provider->keys)) {
				$columns[$key] = [
					"label" => $config["label"],
					"width" => ($key == "id" ? "150px" : "auto")
				];
			}
		}
		$data = $this->provider->getRows();
		return \app\widgets\Table::widget([
			"controls" => $this->controls,
			"data" => $this->fetchExtraData($columns, $data),
			"columns" => $columns,
		]);
	}

	public function fetchExtraData(array $columns, array& $data) {
		$form = $this->provider->getFormModel();
		foreach ($columns as $key => $column) {
			try {
				$config = $form->getConfig($key);
			} catch (\Exception $ignored) {
				continue;
			}
			if (strtolower($config["type"]) == "dropdown" && isset($config["table"])) {
				$fetched = Form::fetch($config["table"]);
				foreach ($data as &$row) {
					if (($value = $row[$key]) != null && isset($fetched[$value])) {
						$row[$key] = $fetched[$value];
					} else {
						$row[$key] = "Нет";
					}
				}
			} else if (strtolower($config["type"]) == "multiple") {
				/* TODO: Not-Implemented */
			} else {
				try {
					$field = FieldCollection::getCollection()->find($config["type"]);
				} catch (\Exception $ignored) {
					continue;
				}
				if ($field instanceof DropDown) {
					foreach ($data as &$row) {
						$row[$key] = $field->getData($row[$key]);
					}
				}
			}
		}
		return $data;
	}
}