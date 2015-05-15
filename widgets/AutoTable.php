<?php

namespace app\widgets;

use app\core\ActiveRecord;
use app\core\DropDown;
use app\core\FieldCollection;
use app\core\FormModel;
use app\core\TableProvider;
use app\core\Widget;
use yii\base\Exception;
use yii\web\ConflictHttpException;

class AutoTable extends Table {

	/**
	 * @var array - Array with control configuration, same
	 * 	as [Table::controls]
	 * @see app\widgets\Table::controls
	 */
	public $controls = [
		"edit" => [
			"tag" => "span",
			"class" => "glyphicon glyphicon-pencil pointer",
			"style" => "margin-left: 5px; margin-right: 5px"
		],
		"delete" => [
			"tag" => "span",
			"class" => "glyphicon glyphicon-remove confirm-delete pointer",
			"style" => "margin-left: 5px; margin-right: 5px; color: #7b1010"
		]
	];

	/**
	 * @var ActiveRecord - Instance of active record instance
	 * 	for current table
	 */
	public $model = null;

	/**
	 * @var FormModel - Table's form model instance with fields
	 * 	configuration
	 */
	public $form = null;

	/**
	 * @var array - Array with provider's elements that should be
	 * 	displayed, by default it uses all fields from [form]
	 * @see form
	 */
	public $keys = [ "*" ];

	/**
	 * Run widget
	 * @return string - Rendered content
	 * @throws Exception
	 */
	public function init() {
		$columns = [];
		if (!empty($this->modelName)) {
			$name = strtolower($this->modelName);
			if (($p = strrpos($name, "\\")) !== false) {
				$name = substr($name, $p + 1);
			}
			$class = "app\\models\\".$name;
			$this->model = new $class();
			$class = "app\\forms\\".$name."Form";
			$this->form = new $class();
		}
		if (!$this->model instanceof ActiveRecord) {
			throw new Exception("Model must be an instance of ActiveRecord class, found \"". gettype($this->model) ."\"");
		}
		if (!$this->form instanceof FormModel) {
			throw new Exception("Form must be an instance of FormModel class, found \"". gettype($this->model) ."\"");
		}
		foreach ($this->form->getConfig() as $key => $config) {
			if (isset($config["hidden"]) && $config["hidden"] || isset($config["type"]) && $config["type"] == "hidden") {
				continue;
			} else if (in_array($key, $this->keys) || in_array("*", $this->keys)) {
				$columns[$key] = [
					"label" => $config["label"],
					"width" => ($key == "id" ? "150px" : "auto")
				];
			}
		}
		$this->header = $columns;
		$this->provider = $this->model->search();
		parent::init();
	}

	public function fetchExtraDataEx(array $columns, array& $data) {
		$form = $this->form;
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
					if (!($field = FieldCollection::getCollection()->find($config["type"])) instanceof DropDown) {
						continue;
					}
				} catch (\Exception $ignored) {
					continue;
				}
				foreach ($data as &$row) {
					$row[$key] = $field->getData($row[$key]);
				}
			}
		}
		return $data;
	}
}