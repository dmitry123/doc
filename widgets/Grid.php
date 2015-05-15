<?php

namespace app\widgets;

use app\core\ObjectHelper;
use app\core\GridProvider;
use app\core\Widget;
use yii\base\Exception;
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
	 * @var \app\core\GridProvider class instance, which provides
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
	 * @throws Exception
	 */
	public function run() {
		if (is_string($this->provider)) {
			$this->provider = new $this->provider();
			if (!$this->provider instanceof GridProvider) {
				throw new Exception("Table provider must be an instance of [app\\core\\Table] class");
			}
		}
		ob_start();
		$this->renderTable();
		return ob_get_clean();
	}

	/**
	 * Get extra configuration for table element, it stores
	 * information about widget and it's provider
	 *
	 * @return array with table configuration
	 */
	public function getExtraConfig() {
		return [
			"data-provider" => $this->provider->className(),
			"data-widget" => $this->className(),
		];
	}

	/**
	 * Render basic table element, which starts
	 * with <table> tag and ends with </table>, it
	 * invokes sub-methods, which renders header,
	 * body and footer elements
	 */
	public function renderTable() {
		print Html::beginTag("table", $this->getExtraConfig() + [
			"class" => $this->provider->tableClass,
			"id" => $this->getId(),
			"data-config" => json_encode($this->config)
		]);
		if ($this->provider->hasHeader) {
			$this->renderHeader();
		}
		$this->renderBody();
		if ($this->provider->hasFooter && $this->provider->getFooter() !== false) {
			print $this->provider->getFooter()->run();
		}
		print Html::endTag("table");
	}

	public function renderHeader() {
		print Html::beginTag("thead", [
			"class" => "table-header"
		]);
		foreach ($this->provider->columns as $key => $attributes) {
			$prepared = $this->prepareHeader($attributes);
			$options = [
				"data-key" => $key
			];
			if ($this->provider->sort !== false) {
				if (isset($this->provider->getSort()->orderBy[$key]) && ($d = $this->provider->getSort()->orderBy[$key]) == SORT_ASC) {
					$options["onclick"] = "$(this).table('order', '-$key')";
				} else {
					$options["onclick"] = "$(this).table('order', '$key')";
				}
				if (!in_array($key, array_keys($this->provider->getSort()->attributes))) {
					unset($options["onclick"]);
				}
			}
			print Html::beginTag("td", $options + $attributes + [
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
		if (!is_string($key) || !isset($this->provider->getSort()->orderBy[$key])) {
			return ;
		} else {
			$direction = $this->provider->getSort()->orderBy[$key];
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
		/** @var $menu ControlMenu */
		if ($this->provider->getMenu() !== false) {
			print $this->provider->getMenu()->run();
		}
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
		if (empty($this->provider->models)) {
			print Html::tag("tr", Html::tag("td", Html::tag("h5", $this->provider->textNoData, [
				"class" => "text-center"
			]), [
				"colspan" => count($this->provider->columns) + ($this->provider->menu != false ? 1 : 0),
			]));
		}
		print Html::endTag("tbody");
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

    public function getAttributes($attributes = null, $excepts = [], $string = null) {
        return parent::getAttributes($attributes, $excepts, [
            "provider"
        ]);
    }
}