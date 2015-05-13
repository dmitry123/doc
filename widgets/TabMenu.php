<?php

namespace app\widgets;

use app\core\Widget;
use yii\helpers\Html;

class TabMenu extends Widget {

	const STYLE_TABS = "nav nav-tabs";
	const STYLE_TABS_JUSTIFIED = "nav nav-tabs nav-justified";
	const STYLE_TABS_STACKED = "nav nav-tabs nav-stacked";
	const STYLE_PILLS = "nav nav-pills";
	const STYLE_PILLS_JUSTIFIED = "nav nav-pills nav-justified";
	const STYLE_PILLS_STACKED = "nav nav-pills nav-stacked";

	/**
	 * @var string identification string of this
	 * 	widget, if null, then generates automatically
	 */
	public $id = null;

	/**
	 * @var array - Array with items, where item is
	 * 	array with href, label, options and sub items
	 * + label - Displayable item label
	 * + [options] - Array with HTML options
	 * + [href] - Href for [a] tag
	 * + [items] - Sub items for DropDown list
	 */
	public $items = [];

	/**
	 * @var string - Default navigation tabs
	 * 	style, see TabMenu styles
	 */
	public $style = self::STYLE_TABS;

	/**
	 * Run widget to return just rendered content
	 * @return string - Just rendered content
	 */
	public function run() {
		ob_start();
		$this->renderItems($this->items);
		return ob_get_clean();
	}

	/**
	 * Render tab menu items, if some item has sub-items, then
	 * it renders it again recursively
	 *
	 * @param $items array with items
	 * @param $depth int tabulation depth
	 */
	public function renderItems($items, $depth = 0) {
		print Html::beginTag("ul", [
			"class" => $this->style,
			"id" => $depth ? null : $this->getId(),
			"role" => "menu"
		]);
		foreach ($items as $class => $item) {
			if (isset($item["href"])) {
				$href = $item["href"];
			} else {
				$href = "javascript:void(0)";
			}
			$options = [
				"role" => "presentation"
			];
			if (!strcasecmp(\Yii::$app->requestedRoute, preg_replace("/^@web\\//", "", $href))) {
				$options["class"] = "$class active";
			} else {
				$options["class"] = $class;
			}
			if (isset($item["items"]) && count($item["items"]) > 0) {
				$options["class"] .= " dropdown";
				$list = $item["items"];
			} else {
				$list = null;
			}
			unset($item["items"]);
			if (isset($item["label"])) {
				$label = $item["label"];
			} else {
				$label = "";
			}
			if (isset($item["options"])) {
				if (isset($item["options"]["class"])) {
					$options["class"] .= " ".$item["options"]["class"];
				}
				$options += $item["options"];
			}
			if (isset($item["icon"])) {
				$label = Html::tag("span", "", [
					"class" => $item["icon"]
				]) ."&emsp;". $label;
			}
			unset($item["options"]);
			unset($item["label"]);
			for ($i = 0; $i < (int) $depth; $i++) {
				$label = "&emsp;".$label;
			}
			print Html::beginTag("li", $options);
			print Html::a($label, $href, $item);
			if ($list != null) {
				$this->renderItems($list, $depth + 1);
			}
			print Html::endTag("li");
		}
		print Html::endTag("ul");
	}
}