<?php

namespace app\widgets;

use app\core\ObjectHelper;
use app\core\Table;
use app\core\Widget;
use yii\helpers\Html;

class Grid extends Widget {

	/**
	 * @var string - Unique identification value of current
	 * 	table, by default it generates automatically with prefix
	 *
	 * @see UniqueGenerator::generate
	 */
	public $id = null;

	/**
	 * @var \app\core\Table class instance, which provides
	 * 	manipulations with ActiveRecord models
	 */
	public $provider = null;

	/**
	 * @var array with extra table configuration, only
	 * 	for internal usage
	 * @internal
	 */
	public $config = [];

	/**
	 * Run widget to catch just rendered table's content
	 * and return it as widget result
	 *
	 * @return string with just rendered table
	 */
	public function run() {
		ob_start();
		$this->renderTable();
		return ob_get_clean();
	}

	/**
	 * Render basic table element, which starts
	 * with <table> tag and ends with </table>, it
	 * invokes sub-methods, which renders header,
	 * body and footer elements
	 */
	public function renderTable() {
		print Html::beginTag("table", [
			"class" => $this->provider->tableClass,
			"id" => $this->id,
			"data-provider" => $this->provider->className(),
			"data-widget" => $this->className(),
			"data-config" => json_encode($this->config)
		]);
		$this->renderHeader();
		$this->renderBody();
		$this->renderFooter();
		print Html::endTag("table");
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
		if ($this->provider->menu != false) {
			print Html::tag("td", "", [
				"width" => $this->provider->menuWidth
			]);
		}
		print Html::endTag("thead");
	}

	public function renderChevron($key) {
		if (!is_string($key) || !isset($this->provider->getSort()->orders[$key])) {
			return ;
		} else {
			$direction = $this->provider->getSort()->orders[$key];
		}
		if ($direction == SORT_ASC) {
			$class = "{$this->provider->chevronDownClass} table-order table-order-asc";
		} else {
			$class = "{$this->provider->chevronUpClass} table-order table-order-desc";
		}
		print "&nbsp;".Html::tag("span", "", [
			"class" => $class
		]);
	}

	/**
	 * Render table controls for each row
	 */
	public function renderMenu() {
		if ($this->provider->menu == false) {
			return ;
		}
		print Html::beginTag("td", [
			"align" => $this->provider->menuAlignment,
			"width" => $this->provider->menuWidth
		]);

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
			if ($this->provider->clickEvent != null) {
				$attributes["onclick"] = $this->provider->clickEvent."(this, '{$model[$this->provider->primaryKey]}')";
			}
			if ($this->provider->doubleClickEvent != null) {
				$attributes["ondblclick"] = $this->provider->doubleClickEvent."(this, '{$model[$this->provider->primaryKey]}')";
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
			"colspan" => count($this->provider->columns) + ($this->provider->menu != false ? 1 : 0),
			"class" => "col-xs-12 no-padding"
		]);
		print Html::beginTag("div", [
			"class" => "col-xs-9 text-left"
		]);
		if ($this->provider->pagination != false) {
			print LinkPager::widget([
				"pagination" => $this->provider->getPagination(),
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
			"class" => "col-xs-2"
		]);
		if ($this->provider->limits !== false) {
			$list = [];
			foreach ($this->provider->limits as $value) {
				$list[$value] = $value;
			}
			if ($this->provider->getPagination() != null) {
				$limit = $this->provider->getPagination()->pageSize;
			} else {
				$limit = $this->provider->limits[0];
			}
			if ($limit !== null && !isset($list[$limit])) {
				$list = [ $limit => $limit ] + $list;
			} else if ($limit === null) {
				$limit = "";
			}
			print Html::dropDownList("limits", $limit, $list, [
				"class" => "form-control",
				"onchange" => "$(this).table('limit', $(this).val())"
			]);
		}
		print Html::endTag("div");
		print Html::endTag("td");
		print Html::endTag("tr");
		print Html::endTag("tfoot");
	}

	/**
	 * Prepare column's headers for usage, it fetch
	 * useful information from attributes array and
	 * returns it as required parameters
	 *
	 * @param $attributes array with column attributes
	 * 	from provider's column array
	 *
	 * @see app\core\Table::columns
	 *
	 * @return array with required attributes
	 */
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
}