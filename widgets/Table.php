<?php

namespace app\widgets;

use app\core\ActiveRecord;
use app\core\DropDown;
use app\core\FieldCollection;
use app\core\FormModel;
use app\core\TableProvider;
use app\core\UniqueGenerator;
use app\core\Widget;
use Exception;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Table extends Widget {

	/**
	 * @var ActiveQuery|string - Default table provider
	 * 	search criteria, you can use it for search
	 * @see MedcardController::actionSearch - Usage example
	 */
	public $criteria = null;

	/**
	 * @var string - CDbCriteria condition, is used for
	 * 	table order or search
	 * @internal
	 */
	public $condition = null;

	/**
	 * @var array - CDbCriteria parameters, is used for
	 * 	table order or search
	 * @internal
	 */
	public $params = null;

	/**
	 * @var TableProvider - Table provider adapter for
	 * 	your table, which has all information about
	 * 	queries and order rules
	 */
	public $provider = null;

	/**
	 * @var array - An array with columns configuration, it
	 * 	has the same structure as in FormModel configuration
	 *
	 * + label - Column label to display
	 * + [style] - Style for current column, like width or color
	 * + [type] - Column default type (for filters in future)
	 * + [width] - Default column width
	 *
	 * @see FormModel::config
	 */
	public $header = null;

	/**
	 * @var string - Default primary key for current table, it
	 * 	uses to receive from data rows unique identification number
	 * 	for tr's [data-id] field
	 */
	public $primaryKey = "id";

	/**
	 * @var int - Current page, that should be displayed, it uses
	 * 	with TablePagination class
	 */
	public $currentPage = 1;

	/**
	 * @var null|string - Default order by key, for null value
	 * 	primary key is used
	 */
	public $orderBy = null;

	/**
	 * @var bool - Shall hide order arrows for tables, which doesn't
	 * 	support ordering or its redundant
	 */
	public $hideOrderByIcon = false;

	/**
	 * @var array - Array with control elements, it's attributes depends on
	 * 	control display mode. You should always use [icon] and [label] attributes
	 * 	cuz every control mode must support that attributes. Control parameters
	 * 	is HTML attributes that moves to it's tag (tag name depends on control display mode).
	 * @see controlMode
	 */
	public $controls = [];

	/**
	 * @var int - How to display control elements, set it
	 * 	to CONTROL_MODE_NONE to disable control elements
	 */
	public $controlMode = ControlMenu::MODE_ICON;

	/**
	 * @var string - Special class for each
	 * 	control element
	 * @see ContorlMenu::special
	 */
	public $controlSpecial = "table-control-button";

	/**
	 * @var string - String with search conditions, uses for
	 * 	table order and search (simply more suitable method
	 * 	for getWidget action)
	 * @see LController::actionGetWidget
	 * @internal
	 */
	public $conditions = "";

	/**
	 * @var array - Array with parameters for search conditions, uses for
	 * 	table order and search (simply more suitable method for getWidget action)
	 * @see LController::actionGetWidget
	 * @internal
	 */
	public $parameters = [];

	/**
	 * @var string - Custom onClick action for table row, you have to
	 * 	set only function or method name without any arguments, cuz it
	 * 	converts it to next format [{$click}.call(this, id)], where
	 * 	id is primary key value of your row from database
	 * @see primaryKey
	 */
	public $click = null;

	/**
	 * @var bool - Should table be empty after first page load, set
	 * 	it to true if your table contains big amount of rows and
	 * 	it's initial render will slow down all render processes, also
	 * 	it removes table footer, cuz it should contains search parameters
	 * @see renderFooter
	 */
	public $emptyData = false;

	/**
	 * @var string - Default table class
	 */
	public $tableClass = "table table-striped table-bordered";

	/**
	 * @var array - Array with data to display, it can be used only
	 * 	if table provider null
	 */
	public $data = null;

	/**
	 * @var string - Unique identification value of current
	 * 	table, by default it generates automatically with prefix
	 * @see UniqueGenerator::generate
	 */
	public $id = null;

	/**
	 * @var int - How many rows should be displayed
	 * 	per one page, default is table pagination's limit
	 * @see TablePagination::pageLimit
	 */
	public $pageLimit = null;

	/**
	 * @var array - An array with available table limits with
	 * 	count of displayable rows per one page, set that value
	 * 	to false to disable limits
	 * @see renderFooter
	 */
	public $availableLimits = [
		10, 25, 50, 75
	];

	/**
	 * @var string - Text message for received empty array
	 * 	with data
	 */
	public $textNoData = "Нет данных";

	/**
	 * @var string - That message will be displayed if
	 * 	field [emptyData] set to true
	 * @see emptyData
	 */
	public $textEmptyData = "Не выбраны критерии поиска";

	/**
	 * @var string - Default placement for bootstrap tooltip
	 * 	component [left, right, top, bottom]
	 */
	public $tooltipDefaultPlacement = "left";

	/**
	 * @var string - Default search criteria for table, it uses
	 * 	to store compiled criteria
	 */
	public $searchCriteria = "";

	/**
	 * @var bool - Shall use optimized pagination for
	 *	higher performance
	 */
	public $optimizedPagination = false;

	/**
	 * @var int - Width of control element column
	 */
	public $controlsWidth = 150;

	/**
	 * Run widget and return just rendered content
	 * @return string - Just rendered content
	 * @throws Exception
	 */
	public function run() {
		if (is_string($this->provider)) {
			$this->provider = ActiveRecord::search($this->provider);
		}
		if (!$this->provider instanceof TableProvider && is_array($this->data)) {
			throw new \Exception("Table provider must be an instance of TableProvider and don't have to be null");
		}
		if (is_string($this->params)) {
			$this->params = unserialize(urldecode($this->params));
		}
		if (empty($this->criteria)) {
			$this->criteria = new ActiveQuery($this->provider->activeRecord->className());
		}
		if (is_string($this->condition) && !empty($this->condition) && is_array($this->parameters)) {
			$this->criteria->on = $this->condition;
			$this->criteria->params = $this->params;
		}
		if (empty($this->id)) {
			$this->id = UniqueGenerator::generate("table");
		}
		foreach ($this->header as $key => &$value) {
			if (!isset($value["id"])) {
				$value["id"] = "";
			}
			if (!isset($value["class"])) {
				$value["class"] = "";
			}
			if (!isset($value["style"])) {
				$value["style"] = "";
			}
		}
		if (empty($this->orderBy)) {
			$this->orderBy = $this->primaryKey;
		}
		$this->data = $this->fetchData();
		$this->searchCriteria = $this->getSearchCriteria();
		return $this->render("@app/widgets/views/Table", [
			"self" => $this
		]);
	}

	/**
	 * Get search criteria for current table provider
	 * @return string - SQL statement for criteria
	 */
	public function getSearchCriteria() {
		$params = $this->provider->getCriteria()->params;
		foreach ($params as $key => &$param) {
			$param = "'$param'";
		}
		return strtr($this->provider->getCriteria()->on, $params);
	}

	/**
	 * Fetch array with data from table provider or something else
	 * @return array - Array with provider's data
	 */
	public function fetchData() {
		if ($this->emptyData !== false) {
			if ($this->provider !== null) {
				$this->provider->getPagination()->calculate(0);
			}
			return [];
		} else if ($this->provider == null && is_array($this->data)) {
			return $this->data;
		}
		$this->provider->getPagination()->optimizedMode = $this->optimizedPagination;
		$this->provider->getPagination()->currentPage = $this->currentPage;
		if ($this->pageLimit != null) {
			$this->provider->getPagination()->pageLimit = $this->pageLimit;
		}
		if ($this->condition != null) {
			$this->provider->getCriteria()->andOnCondition($this->condition);
		}
		if ($this->params != null) {
			$this->provider->getCriteria()->params += $this->params;
		}
		if (is_object($this->criteria)) {
			$this->provider->getCriteria()->addOrderBy($this->criteria->orderBy);
			$this->provider->getCriteria()->andOnCondition($this->criteria->on);
		}
		if (!empty($this->orderBy)) {
			$this->provider->orderBy = $this->orderBy;
		}
		if (!empty($this->searchCriteria)) {
			$this->provider->fetchQuery->where($this->searchCriteria);
			$this->provider->countQuery->where($this->searchCriteria);
		}
		$form = preg_replace('/(^\d*)|(\d*$)/', "", get_class($this->provider->activeRecord))."Form";
		if (!class_exists($form)) {
			return $this->data = $this->provider->fetchData();
		} else {
			$this->data = $this->provider->fetchData();
		}
		$model = new $form($this->provider->activeRecord->getScenario());
		if (!$model instanceof FormModel) {
			return $this->data;
		}
		foreach ($this->data as &$row) {
			$this->fetchExtraData($model, $row);
		}
		return $this->data;
	}

	/**
	 * Fetch extra data from rows and database by model's form
	 * @param FormModel $form - Database table's form model instance
	 * @param mixed $row - Array with fetched data
	 * @throws Exception
	 */
	public static function fetchExtraData($form, &$row) {
		foreach ($form->getConfig() as $key => $config) {
			if ($config["type"] != "DropDown" || !isset($config["table"])) {
				$field = FieldCollection::getCollection()->find($config["type"], false);
				if ($field != null && $field instanceof DropDown) {
					$row[$key] = $field->getData($row[$key]);
				}
			} else {
				$data = Form::fetch($config["table"]);
				if (($value = $row[$key]) != null && isset($data[$value])) {
					$row[$key] = $data[$value];
				} else {
					$row[$key] = "Нет";
				}
			}
		}
	}

	/**
	 * Render extra information for table header with search
	 * conditions and parameters, need for update requests
	 */
	public function renderExtra() {
		print Html::renderTagAttributes($options = [
			"data-class" => get_class($this),
			"data-widget" => get_class($this),
			"data-url" => $this->createUrl()
		]);
	}

	/**
	 * Format data row's cell
	 * @param string $format - Format string
	 * @param array $cell - Array with cell data
	 * @return string - Formatted result
	 */
	private function format($format, $cell) {
		preg_match_all("/%\\{([a-zA-Z_0-9]+)\\}/", $format, $matches);
		$value = $format;
		if (count($matches)) {
			foreach ($matches[1] as $m) {
				$value = preg_replace("/\\%{{$m}}/", $cell[$m], $value);
			}
		}
		return $value;
	}

	/**
	 * Render table's body
	 */
	public function renderBody() {
		foreach ($this->fetchData() as $key => $value) {
			$options = [
				"data-id" => $value[$this->primaryKey],
				"class" => "core-table-row"
			];
			if (is_string($this->click)) {
				$options["onclick"] = $this->click . "(this, '{$value[$this->primaryKey]}')";
			}
			print Html::beginTag("tr", $options);
			foreach ($this->header as $k => $v) {
				if (isset($v["format"])) {
					$val = $this->format($v["format"], $value);
				} else {
					$val = isset($value[$k]) ? $value[$k] : "";
				}
				print Html::tag("td", $val, [
					"align" => "left",
					"class" => "core-table-cell"
				]);
			}
			$this->renderControls();
			print Html::endTag("tr");
		}
		if (count($this->data) == 0) {
			if ($this->emptyData) {
				$text = $this->textEmptyData;
			} else {
				$text = $this->textNoData;
			}
			print Html::tag("tr", Html::tag("td", "<b>$text</b>", [
				"colspan" => count($this->header) + 1
			]));
		}
	}

	/**
	 * Render table header with information about
	 * columns
	 */
	public function renderHeader() {
		print Html::beginTag("tr", [
			"class" => "core-table-row"
		]);
		foreach ($this->header as $key => $value) {
			$options = [
				"data-key" => $key,
				"onclick" => "$(this).table('order', '$key')",
				"align" => "left"
			];
			if (!empty($value["id"])) {
				$options["id"] = $value["id"];
			}
			if (!empty($value["class"])) {
				$options["class"] = $value["class"];
			}
			if (!empty($value["style"])) {
				$options["style"] = $value["style"];
			}
			print Html::beginTag("td", $options);
			print Html::tag("b", $this->header[$key]["label"]);
			$this->renderChevron($key);
			print Html::endTag("td");
		}
		if (count($this->controls) > 0) {
			print Html::tag("td", "", [
				"align" => "middle",
				"style" => "width: {$this->controlsWidth}px"
			]);
		}
		print Html::endTag("tr");
	}

	/**
	 * Render table controls for each row
	 */
	public function renderControls() {
		if (!is_array($this->controls) || !count($this->controls)) {
			return ;
		}
		print Html::beginTag("td", [
			"align" => "middle"
		]);
		print ControlMenu::widget([
			"controls" => $this->controls,
			"mode" => $this->controlMode,
			"special" => $this->controlSpecial,
		]);
		print Html::endTag("td");
	}

	/**
	 * Render chevron only for ordered column
	 * @param string $key - Current key
	 */
	public function renderChevron($key) {
		if (($p = strpos($this->orderBy, " ")) !== false) {
			$orderBy = substr($this->orderBy, 0, $p);
		} else {
			$orderBy = $this->orderBy;
		}
		if ($orderBy !== $key || $this->hideOrderByIcon !== false) {
			return ;
		}
		if (strpos($this->orderBy, "desc") !== false) {
			$class = "glyphicon glyphicon-chevron-up table-order table-order-desc";
		} else {
			$class = "glyphicon glyphicon-chevron-down table-order table-order-asc";
		}
		print Html::tag("span", "", [
			"class" => $class
		]);
	}

	/**
	 * Render table footer with different
	 * control elements, like pagination
	 * or search
	 */
	public function renderFooter() {
		if ($this->emptyData !== false) {
			return ;
		}
		print Html::beginTag("tr", [
			"class" => "core-table-row"
		]);
		print Html::beginTag("td", [
			"colspan" => count($this->header) + (!empty($this->controls) ? 0 : -1),
			"align" => "left"
		]);
		if ($this->provider->pagination !== false) {
			print Pagination::widget([
				"tablePagination" => $this->provider->getPagination(),
				"clickAction" => function($page) {
					return "$(this).table('page', {$page})";
				}
			]);
		}
		print Html::endTag("td");
		print Html::beginTag("td", [
			"align" => "right"
		]);
		if ($this->availableLimits !== false) {
			$list = [];
			foreach ($this->availableLimits as $value) {
				$list[$value] = $value;
			}
			if ($this->provider->pagination != null) {
				$limit = $this->provider->pagination->pageLimit;
			} else {
				$limit = $this->pageLimit;
			}
			if ($limit !== null && !isset($list[$limit])) {
				$list[$limit] = $limit;
			} else if ($limit === null) {
				$limit = "";
			}
			print Html::dropDownList("availableLimits", $limit, $list, [
				"class" => "form-control text-center",
				"style" => "width: 75px",
				"onchange" => "$(this).table('limit', $(this).val())"
			]);
		}
		print Html::endTag("td");
		print Html::endTag("tr");
	}

	/**
	 * Serialize widget's attributes by all scalar attributes and
	 * arrays or set your own array with attribute names
	 *
	 * Agreement: I hope that you will put serialized attributes
	 *    in root widget's HTML tag named [data-attributes]
	 *
	 * @param array|null $attributes - Array with attributes, which have
	 *    to be serialized, by default it serializes all scalar attributes
	 *
	 * @param array|null $excepts - Array with attributes, that should
	 * 	be excepted
	 *
	 * @return string - Serialized and URL encoded attributes
	 */
	public function getSerializedAttributes($attributes = null, $excepts = []) {
		return parent::getSerializedAttributes($attributes, ArrayHelper::merge($excepts, [
			/*
			 * Don't let widget to serialize array
			 * with data, pff :D
			 */
			"data",
			/*
			 * Allow this fields only if you want to
			 * didn't declare custom widget for ur table
			 */
			"availableLimits",
			"tooltipDefaultPlacement",
			"textNoData",
			"textEmptyData",
			/*
			 * We can't allow widget to set [emptyData] attribute for actions
			 * like search or update, cuz it will always return empty data
			 */
			"emptyData"
		]));
	}
}