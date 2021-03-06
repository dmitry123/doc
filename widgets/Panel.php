<?php

namespace app\widgets;

use app\core\ClassTrait;
use app\core\UniqueGenerator;
use app\core\Widget;

class Panel extends Widget {

	/**
	 * Constants for panel's wrapper class
	 */
	const PANEL_CLASS_DEFAULT = "panel panel-default";
	const PANEL_CLASS_PRIMARY = "panel panel-primary";
	const PANEL_CLASS_SUCCESS = "panel panel-success";
	const PANEL_CLASS_DANGER = "panel panel-danger";
	const PANEL_CLASS_WARNING = "panel panel-warning";

	/**
	 * @var string panel's primary key, by default it
	 * 	generates automatically
	 *
	 * @see UniqueGenerator::generate
	 */
	public $id = null;

	/**
	 * @var string panel's title, which displays
	 *	 in panel's heading
	 */
	public $title = "";

	/**
	 * @var string|null|Widget body content, if null, then content
	 *	obtains from print stream
	 */
	public $body = null;

	/**
	 * @var string default panel style
	 */
	public $panelClass = self::PANEL_CLASS_DEFAULT;

	/**
	 * @var string style of panel's heading, by default it uses row, cuz it has
	 * 	hidden glyphicons in [col-xs-12] wrapper, which needs fixed height
	 */
	public $headingClass = "panel-heading row no-margin";

	/**
	 * @var string style of panel's body, you can
	 * 	add [no-padding] style to remove panel's body padding
	 */
	public $bodyClass = "panel-body";

	/**
	 * @var string classes for panel's content block, which
	 * 	separated in body container {.panel-body > .row > .panel-content}
	 */
	public $contentClass = "col-xs-12 no-padding no-margin panel-content";

	/**
	 * @var string classes for heading's title
	 * 	div container
	 */
	public $titleWrapperClass = "col-xs-6 text-left no-padding";

	/**
	 * @var string classes for control container which
	 * 	separated after title container
	 */
	public $controlsWrapperClass = "col-xs-6 text-right no-padding";

	/**
	 * @var string classes for panel's title, which separated
	 * 	in panel's heading and wrapped by it's wrapper
	 */
	public $titleClass = "panel-title";

	/**
	 * @var bool should panel be collapsible with
	 * 	collapse/expand button, it don't take any effect
	 * 	if [controlModel] sets to CONTROL_MODE_ICON
	 *
	 * @see controlMode
	 */
	public $collapsible = false;

	/**
	 * @var bool should panel be upgradable with refresh button, it
	 * 	will take any effects only if [body] is widget object, which
	 * 	has bee created via [@see Widget::createWidget] method
	 *
	 * @see body
	 * @see Widget::createWidget
	 */
	public $upgradable = true;

	/**
	 * @var array with control elements, it's attributes depends on
	 * 	control display mode. You should always use [icon] and [label] attributes
	 * 	cuz every control mode must support that attributes. Control parameters
	 * 	is HTML attributes that moves to it's tag (tag name depends on control
	 * 	display mode).
	 *
	 * @see ControlMenu
	 * @see controlMode
	 */
	public $controls = [];

	/**
	 * @var int how to display control elements, set it
	 * 	to CONTROL_MODE_NONE to disable control elements
	 *
	 * @see ControlMenu
	 */
	public $controlMode = ControlMenu::MODE_BUTTON;

	/**
	 * @var string string with serialized parameters
	 * @internal
	 */
	public $attributes = null;

	/**
	 * @var string content of panel's footer
	 */
	public $footer = null;

	/**
	 * Initialize widget
	 */
    public function init() {
        if ($this->body instanceof Widget) {
			$this->_widget = $this->body->className();
			if ($this->body instanceof Grid) {
				$config = [ "provider" => $this->body->provider->className() ];
			} else {
				$config = $this->body->getConfig();
			}
			$this->attributes = $this->body->getAttributes($config);
            $this->body = $this->body->call();
        } else {
			if ($this->upgradable !== null) {
				$this->upgradable = false;
			}
			$this->_widget = null;
		}
		if (empty($this->id)) {
			$this->id = UniqueGenerator::generate("panel");
		}
		if ($this->footer instanceof Widget) {
			ob_start();
			print $this->footer->run();
			$this->footer =  ob_get_clean();
		}
		if ($this->body == null) {
			ob_start();
		}
		if ($this->upgradable) {
			$this->controls += [
				"panel-update-button" => [
					"label" => "Обновить",
					"icon" => "glyphicon glyphicon-refresh",
					"onclick" => "$(this).panel('update')",
					"class" => "btn btn-default btn-sm",
				],
			];
		}
		if ($this->collapsible) {
			$this->controls += [
				"panel-collapse-button" => [
					"label" => "Свернуть/Развернуть",
					"icon" => "glyphicon glyphicon-asterisk",
					"onclick" => "$(this).panel('toggle')",
					"class" => "btn btn-default btn-sm",
				]
			];
		}
    }

	/**
	 * Run widget
	 */
    public function run() {
		return $this->render("Panel", [
			"content" => $this->body ? $this->body : ob_get_clean(),
			"self" => $this,
			"parameters" => $this->attributes,
			"widget" => $this->_widget,
		]);
    }

	/**
	 * Render panel's control elements
	 */
	public function renderControls() {
		print ControlMenu::widget([
			"controls" => $this->controls,
			"mode" => $this->controlMode,
			"special" => "panel-control-button"
		]);
	}

	private $_widget;
} 