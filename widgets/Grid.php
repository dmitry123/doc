<?php

namespace app\widgets;

use app\core\ActiveDataProvider;
use app\core\ObjectHelper;
use app\core\Widget;
use yii\helpers\Html;

class Grid extends Widget {

	/**
	 * Default control menu display mode. To override it change
	 * control menu provider's field [mode]
	 *
	 * @see ControlMenu::mode
	 * @see createControlMenu
	 * @see menu
	 */
	const CONTROL_MENU_MODE = ControlMenu::MODE_ICON;

	/**
	 * Default special class for control menu element. To override
	 * it change control menu provider's field [special]
	 *
	 * @see ControlMenu::special
	 * @see createControlMenu
	 * @see menu
	 */
	const CONTROL_MENU_SPECIAL = "table-control-button";

	/**
	 * @var string - Unique identification value of current
	 * 	table, by default it generates automatically with prefix
	 *
	 * @see UniqueGenerator::generate
	 */
	public $id = null;

	/**
	 * @var ActiveDataProvider class instance, which provides
	 * 	manipulations with ActiveRecord models
	 */
	public $provider = null;

	/**
	 * @var ControlMenu|array instance of ControlMenu class or array
	 * 	with class configuration, which renders row's menu
	 *
	 * @see ControlMenu
	 */
	public $menu = false;

	/**
	 * @var string control menu elements alignment
	 */
	public $menuAlignment = "middle";

	/**
	 * @var bool - Should table be empty after first page load, set
	 * 	it to true if your table contains big amount of rows and
	 * 	it's initial render will slow down all render processes, also
	 * 	it removes table footer, cuz it should contains search parameters
	 *
	 * @see renderFooter
	 */
	public $emptyData = false;

	/**
	 * @var string default table class which wraps table's
	 * 	header, body and footer
	 */
	public $tableClass = "table table-striped";

	/**
	 * @var string text message for received empty array
	 * 	with data
	 */
	public $textNoData = "Нет данных";

	/**
	 * @var string message will be displayed if
	 * 	field [emptyData] set to true
	 *
	 * @see emptyData
	 */
	public $textEmptyData = "Не выбраны критерии поиска";

	/**
	 * @var string default placement for bootstrap tooltip
	 * 	component [left, right, top, bottom]
	 */
	public $tooltipDefaultPlacement = "left";

	/**
	 * @var string width of column with control elements
	 */
	public $menuWidth = "50px";

	/**
	 * @var string identification string of current
	 * 	module, only for internal usage
	 *
	 * @internal changing that property may
	 * 	crash widget or do nothing
	 */
	public $module = null;

	/**
	 * @var string with name of glyphicon class for
	 * 	chevron order icon (DESC)
	 */
	public $chevronUpClass = "glyphicon glyphicon-chevron-up";

	/**
	 * @var string with name of glyphicon class for
	 * 	chevron order icon (ASC)
	 */
	public $chevronDownClass = "glyphicon glyphicon-chevron-down";

	/**
	 * @var string with javascript code which provides actions on
	 * 	row's click, you should set only function name, other method
	 *	call binds automatically
	 */
	public $clickEvent = null;

	/**
	 * @var string|callable with javascript code which provides
	 * 	actions on row's double click
	 */
	public $doubleClickEvent = null;

	/**
	 * Create control menu element with configuration
	 * array, it will pull it with default values
	 *
	 * @param $menu array with control menu
	 * 	configuration
	 *
	 * @return ControlMenu class instance
	 */
	public function createControlMenu(array& $menu) {
		if (!isset($menu["mode"])) {
			$menu["mode"] = static::CONTROL_MENU_MODE;
		}
		if (!isset($menu["special"])) {
			$menu["special"] = static::CONTROL_MENU_SPECIAL;
		}
		return ObjectHelper::ensure($menu, ControlMenu::className());
	}

	public function run() {
		ob_start();
		$this->renderTable();
		return ob_get_clean();
	}

	public function renderTable() {
		print Html::beginTag("table", [
			"class" => $this->tableClass,
			"id" => $this->id,
			"data-widget" => $this->className(),
			"data-attributes" => json_encode($this)
		]);
		$this->renderHeader();
		$this->renderBody();
		$this->renderFooter();
		print Html::endTag("table");
	}

	private function prepareHeader(&$attributes) {
		if (!is_array($attributes)) {
			$attributes = [
				"label" => $attributes
			];
		}
		if (isset($attributes["label"])) {
			$label = $attributes["label"];
		} else {
			$label = "";
		}
		unset($attributes["label"]);
		return [
			"label" => $label
		];
	}

	public function renderHeader() {
		print Html::beginTag("thead", [
			"class" => "table-header"
		]);
		foreach ($this->provider->columns as $key => $attributes) {
			$prepared = $this->prepareHeader($attributes);
			print Html::beginTag("td", [
					"data-key" => $key,
					"onclick" => "$(this).table('order', '$key')",
				] + $attributes + [
					"align" => "left"
				]);
			print Html::tag("b", $prepared["label"]);
			$this->renderChevron($key);
			print Html::endTag("td");
		}
		if (!empty($this->menu)) {
			print Html::tag("td", "", [
				"width" => $this->menuWidth
			]);
		}
		print Html::endTag("thead");
	}

	public function renderChevron($key) {
		if (!is_string($key) || !isset($this->provider->sort->orders[$key])) {
			return ;
		} else {
			$direction = $this->provider->sort->orders[$key];
		}
		if ($direction == SORT_ASC) {
			$class = "$this->chevronDownClass table-order table-order-asc";
		} else {
			$class = "$this->chevronUpClass table-order table-order-desc";
		}
		print "&nbsp;".Html::tag("span", "", [
			"class" => $class
		]);
	}

	/**
	 * Render table controls for each row
	 */
	public function renderMenu() {
		if (empty($this->menu)) {
			return ;
		}
		print Html::beginTag("td", [
			"align" => $this->menuAlignment,
			"width" => $this->menuWidth
		]);
		$this->createControlMenu($this->menu)->run();
		print Html::endTag("td");
	}

	public function renderBody() {
		print Html::beginTag("tbody", [
			"class" => "table-body"
		]);
		foreach ($this->provider->models as $model) {
			$attributes = [
				"data-id" => $model[$this->provider->primaryKey],
				"class" => "table-row"
			];
			if ($this->clickEvent != null) {
				$attributes["onclick"] = $this->clickEvent."(this, '{$model[$this->provider->primaryKey]}')";
			}
			if ($this->doubleClickEvent != null) {
				$attributes["ondblclick"] = $this->doubleClickEvent."(this, '{$model[$this->provider->primaryKey]}')";
			}
			print Html::beginTag("tr", $attributes);
			foreach ($this->provider->columns as $key => $attributes) {
				$this->prepareHeader($attributes);
				print Html::tag("td", isset($model[$key]) ? $model[$key] : "", [
						"class" => "table-cell"
					] + $attributes + [
						"align" => "left",
					]);
			}
			$this->renderMenu();
			print Html::endTag("tr");
		}
		print Html::endTag("tbody");
	}

	public function renderFooter() {
		print Html::beginTag("tfoot", [
			"class" => "table-footer"
		]);
		print Html::beginTag("tr");
		print Html::beginTag("td", [
			"colspan" => count($this->provider->columns) + (empty($this->menu) ? 0 : 1),
			"class" => "col-xs-12 no-padding"
		]);
		print Html::beginTag("div", [
			"class" => "col-xs-10 text-left"
		]);
		if ($this->provider->pagination != false) {
			print LinkPager::widget([
				"pagination" => $this->provider->pagination,
				"hideOnSinglePage" => false
			]);
		}
		print Html::endTag("div");
		print Html::beginTag("div", [
			"class" => "col-xs-1 text-center"
		]);
		print Html::tag("span", "", [
			"class" => "glyphicon glyphicon-search table-search-icon",
			"onmouseenter" => "$(this).tooltip('show')",
			"data-placement" => "left",
			"data-original-title" => "Поиск"
		]);
		print Html::endTag("div");
		print Html::beginTag("div", [
			"class" => "col-xs-1 text-center"
		]);
		if ($this->provider->availableLimits !== false) {
			$list = [];
			foreach ($this->provider->availableLimits as $value) {
				$list[$value] = $value;
			}
			if ($this->provider->pagination != null) {
				$limit = $this->provider->pagination->pageSize;
			} else {
				$limit = $this->provider->availableLimits[0];
			}
			if ($limit !== null && !isset($list[$limit])) {
				$list = [ $limit => $limit ] + $list;
			} else if ($limit === null) {
				$limit = "";
			}
			print Html::dropDownList("availableLimits", $limit, $list, [
				"class" => "form-control",
				"onchange" => "$(this).table('limit', $(this).val())"
			]);
		}
		print Html::endTag("div");
		print Html::endTag("tr");
		print Html::endTag("tfoot");
	}
}