<?php

namespace app\widgets;

use app\core\Widget;
use Exception;
use yii\helpers\Html;

class ControlMenu extends Widget {

	/**
	 * Disable control elements, has no attributes, so array
	 * may be null or empty (same effect)
	 */
	const MODE_NONE = 0;

	/**
	 * Control elements displays as <a> tag with label, attributes:
	 *  + label - displayable <a> text
	 *  + [icon] - name of glyphicon class
	 *  + ... - other HTML attributes (for <a>)
	 * Warning: it automatically removes all classes which starts
	 *  with 'btn', cuz it helps to use it button and icon mode together
	 * @see buttonRegexp
	 */
	const MODE_TEXT = 1;

	/**
	 * Control elements displays as glyphicons with tooltips, attributes:
	 *  + [label] - text for tooltip
	 *  + icon - class for glyphicon
	 *  + ... - other HTML attributes (for <span>)
	 * Warning: it automatically removes all classes which starts
	 *  with 'btn', cuz it helps to use it button and icon mode together
	 * @see buttonRegexp
	 */
	const MODE_ICON = 2;

	/**
	 * Control elements displays as buttons, attributes:
	 *  + label - button text
	 *  + [icon] - glyphicon before button's text
	 *  + ... - other HTML attributes
	 */
	const MODE_BUTTON = 3;

	/**
	 * Control elements displays as dropdown list, attributes:
	 *  + label - menu item label
	 *  + [icon] - glyphicon before item's text
	 *  + ... - other HTML attributes
	 */
	const MODE_MENU   = 4;

	/**
	 * @var int - How to display control elements, set it
	 * 	to CONTROL_MODE_NONE to disable control elements
	 */
	public $mode = self::MODE_ICON;

	/**
	 * @var array - Array with control elements, it's attributes depends on
	 * 	control display mode. You should always use [icon] and [label] attributes
	 * 	cuz every control mode must support that attributes. Control parameters
	 * 	is HTML attributes that moves to it's tag (tag name depends on control
	 * 	display mode).
	 * @see controlMode
	 */
	public $controls = null;

	/**
	 * @var string - Regular expression to remove button classes from
	 * 	icon and text elements
	 */
	public $buttonRegexp = "/btn\\-*[a-z]* /";

	/**
	 * @var string - Name of special class which automatically
	 * 	adds to every control element
	 */
	public $specialClass = "panel-control-button";

	/**
	 * Run widget to render control elements
	 */
	public function run() {
		if (!empty($this->controls)) {
			$this->renderControls();
		}
	}

	public function prepareControl($key, array& $attributes) {
		if (isset($attributes["label"])) {
			$label = $attributes["label"];
		} else {
			$label = null;
		}
		if (isset($attributes["icon"])) {
			$icon = $attributes["icon"];
		} else {
			$icon = null;
		}
		unset($attributes["label"]);
		unset($attributes["icon"]);
		if (!isset($attributes["class"])) {
			$attributes["class"] = "$this->specialClass $key";
		} else {
			$attributes["class"] .= " $this->specialClass $key";
		}
		return [
			"label" => $label,
			"icon" => $icon
		];
	}

	public function renderTextControls() {
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required["label"])) {
				throw new Exception("Panel's controls mode [CONTROL_MODE_BUTTON] requires [label] attribute");
			} else {
				$label = $required["label"];
			}
			if (!empty($required["icon"])) {
				$label = Html::tag("span", "", [
						"class" => $required["icon"]
					]) ."&nbsp;&nbsp;". $label;
			}
			$options["class"] = preg_replace($this->buttonRegexp, "", $options["class"]);
			print Html::tag("a", $label, $options);
		}
	}

	public function renderIconControls() {
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required["icon"])) {
				throw new Exception("Panel's controls mode [CONTROL_MODE_ICON] requires [icon] attribute");
			} else {
				$options["class"] .= " ".$required["icon"];
			}
			if (!empty($required["label"])) {
				$options += [
					"onmouseenter" => "$(this).tooltip('show')",
					"title" => $required["label"],
					"data-placement" => "left"
				];
			}
			$options["class"] = preg_replace($this->buttonRegexp, "", $options["class"]);
			print Html::tag("span", "", $options);
		}
	}

	public function renderButtonControls() {
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required["label"])) {
				throw new Exception("Panel's controls mode [CONTROL_MODE_BUTTON] requires [label] attribute");
			} else {
				$label = $required["label"];
			}
			if (!empty($required["icon"])) {
				$label = Html::tag("span", "", [
					"class" => $required["icon"]
				]) ."&nbsp;&nbsp;". $label;
			}
			print Html::tag("button", $label, $options);
		}
	}

	public function renderMenuControls() {
		print Html::beginTag("div", [
			"class" => "dropdown"
		]);
		print Html::tag("div", Html::tag("span", "", [
			"class" => "glyphicon glyphicon-list"
		]), [
			"href" => "javascript:void(0)",
			"class" => "dropdown-toggle",
			"data-toggle" => "dropdown",
			"aria-haspopup" => "true",
			"role" => "button",
			"aria-expanded" => "false",
			"style" => "cursor: pointer",
		]);
		print Html::beginTag("ul", [
			"class" => "dropdown-menu",
			"role" => "menu"
		]);
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required["label"])) {
				throw new Exception("Panel's controls mode [CONTROL_MODE_MENU] requires [label] attribute");
			} else {
				$label = $required["label"];
			}
			if (!empty($required["icon"])) {
				$label = Html::tag("span", "", [
						"class" => $required["icon"]
					]) ."&nbsp;&nbsp;". $label;
			}
			$options["class"] = preg_replace($this->buttonRegexp, "", $options["class"]);
			print Html::tag("li", Html::tag("a", $label, [
					"role" => "menuitem",
					"tagindex" => "-1"
				] + $options), [
					"role" => "presentation",
					"class" => "text-left"
				]
			);
		}
		print Html::endTag("ul");
		print Html::endTag("div");
	}

	/**
	 * Render menu with control elements
	 */
	public function renderControls() {
		switch ($this->mode) {
			case self::MODE_TEXT:
				$this->renderTextControls();
				break;
			case self::MODE_ICON:
				$this->renderIconControls();
				break;
			case self::MODE_BUTTON:
				$this->renderButtonControls();
				break;
			case self::MODE_MENU:
				$this->renderMenuControls();
				break;
		}
	}
}