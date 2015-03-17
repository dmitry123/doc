<?php

namespace app\widgets;

use app\core\TableProvider;
use app\core\Widget;
use yii\base\ErrorException;
use yii\helpers\Html;

class Table extends Widget {

	/**
	 * @var TableProvider - Instance of model, which extends
	 * 	TableProvider class
	 */
	public $provider = null;

	/**
	 * @var array - An array with table columns to display, where key is
	 * 	name of column, which return TableProvider and value is:
	 * +
	 * +
	 * +
	 */
	public $columns = [];

	/**
	 * @var array - An array with control buttons, where every control is
	 * 	displayable control element, any class element which can be
	 * 	casted to string
	 */
	public $controls = null;

	/**
	 * @var array
	 */
	public $classes = [
		"table" => "table table-hover table-bordered table-condensed table-striped",
		"active" => "",
		"row" => ""
	];

	/**
	 * @var array - Array with data to display, by default it loads provider
	 * 	and fetches rows for provider's table
	 */
	public $data = null;

	/**
	 * @var array|string|bool - Array with fields that can be used to order table, by
	 * 	default it can be ordered with every field, set it to false if you want to disable ordering
	 */
	public $order = "*";

	/**
	 * @var string|bool - Current order parameters, it will be changed with ajax
	 * 	update, or set it to false if you want to disable default order
	 */
	public $orderBy = "id";

	/**
	 * @var bool - Order direction, default is false
	 */
	public $desc = false;

	/**
	 * Run widget execution
	 * @throws ErrorException on configuration errors
	 */
	public function run() {
		if (!$this->provider instanceof TableProvider && $this->data && $this->provider != null) {
			throw new ErrorException("Table provider must be instance of TableProvider class and mustn't be null, found \"" . get_class($this->provider) . "\"");
		}
		if (!count($this->columns)) {
			throw new ErrorException("Count of table columns must be above zero");
		}
		if ($this->provider != null) {
			if ($this->data != null) {
				$this->data = array_merge($this->provider->getRows(), $this->data);
			} else {
				$this->data = $this->provider->getRows();
			}
		}
		$this->renderTable();
	}

	protected function renderHeader() {
		print Html::beginTag("tr");
		foreach ($this->columns as $key => $column) {
			if ($this->provider != null) {
				$config = $this->provider->getFormModel()->getConfig($key);
			} else {
				$config = $column;
			}
			if (!isset($column["label"])) {
				if (isset($config["label"])) {
					$label = $config["label"];
				} else {
					$label = "";
				}
			} else {
				$label = $column["label"];
			}
			$options = [];
			if (isset($column["width"])) {
				$options["width"] = $column["width"];
			}
			if ($label == "#") {
				$options["align"] = "middle";
			}
			if ($this->order == "*" || in_array($key, $this->order)) {
				$label = Html::tag("a", $label, [
					"href" => "javascript:void(0)"
				]);
			}
			if ($this->orderBy !== false && $this->orderBy == $key) {
				if ($this->desc) {
					$class = "glyphicon glyphicon-sort-by-alphabet";
				} else {
					$class = "glyphicon glyphicon-sort-by-alphabet-alt";
				}
				$label .= "&nbsp;" . Html::tag("span", "", [
					"style" => "color: gray; vertical-align: middle",
					"class" => $class
				]);
			}
			print Html::tag("td", $label, $options + [
					"style" => "vertical-align: middle",
					"class" => "text-center"
				]);
		}
		if ($this->controls != null && count($this->controls) > 0) {
			print Html::tag("td", "Управление", [
				"width" => "auto",
				"class" => "text-center"
			]);
		}
		print Html::endTag("tr");
	}

	protected function renderBody() {
		foreach ($this->data as $row) {
			print Html::beginTag("tr");
			foreach ($this->columns as $key => $column) {
				if (isset($column["options"])) {
					$options = $column["options"];
				} else {
					$options = [];
				}
				if (isset($column["width"])) {
					$options += [
						"width" => $column["width"]
					];
				}
				print Html::tag("td", $row[$key], $options + [
						"align" => "middle"
					]);
			}
			if ($this->controls != null && count($this->controls) > 0) {
				print Html::beginTag("td", [
					"align" => "middle",
					"width" => "auto"
				]);
				foreach ($this->controls as $key => $control) {
					$tag = isset($control["tag"]) ? $control["tag"] : "span";
					$options = isset($control["options"]) ? $control["options"] : [];
					$label = isset($control["label"]) ? $control["label"] : "";
					print Html::tag($tag, $label, $options);
				}
				print Html::endTag("td");
			}
			print Html::endTag("tr");
		}
	}

	protected function renderFooter() {

	}

	protected function renderTable() {
		print Html::beginTag("table", [
			"class" => isset($this->classes["table"]) ? $this->classes["table"] : ""
		]);
		print Html::beginTag("thead");
		$this->renderHeader();
		print Html::endTag("thead");
		print Html::beginTag("tbody");
		$this->renderBody();
		print Html::endTag("thead");
		print Html::beginTag("tfoot");
		$this->renderFooter();
		print Html::endTag("thead");
		print Html::endTag("table");
	}

	protected function getClass($key = null, $attributes = []) {
		if ($key != null && isset($this->classes[$key]) && !empty($this->classes[$key])) {
			$class = "class=\"{$this->classes[$key]} ";
		} else {
			$class = "";
		}
		if (count($attributes) > 0 && $class == "") {
			$class = "class=\"";
		}
		foreach ($attributes as $value) {
			$class .= $value . " ";
		}
		if (strlen($class) > 0) {
			return $class . "\"";
		} else {
			return $class;
		}
	}
}