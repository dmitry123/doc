<?php

namespace app\components\widgets;

use app\components\UniqueGenerator;
use yii\helpers\Html;

class Modal extends \yii\bootstrap\Modal {

	/**
	 * @var string|callable - Some printable body content or function
	 * 		that returns printable content based on widget configuration
	 */
	public $body = null;

	/**
	 * @var string - Modal window title, which will be displayed
	 * 		in header
	 */
	public $title = null;

	/**
	 * @var array - Array with buttons to display, where key is
	 * 		button class and value if array with configuration, where
	 * 		text is displayable text, class is extra classes and type
	 * 		is button type
	 */
	public $buttons = [];

	/**
	 * @var bool - Set it to false to remove default cancel button
	 */
	public $cancel = true;

	/**
	 * @var string - Modal window identification number
	 */
	public $id = null;

	/**
	 * @var string - Body wrapper classes
	 */
	public $wrapper = "col-xs-12 col-xs-offset-0";

	/**
	 * Initializes the widget. This method will register the bootstrap asset
	 * bundle. If you override this method, make sure you call the parent implementation first.
	 */
	public function init() {
		if ($this->title != null) {
			$this->header = Html::tag("h4", $this->title, [
				"style" => "margin: 0"
			]);
		}
		if (empty($this->footer)) {
			if ($this->cancel == true) {
				$this->footer = Html::tag("button", "Закрыть", [
					"class" => "btn btn-default cancel-button",
					"type" => "button",
					"data-dismiss" => "modal"
				]);
			} else {
				$this->footer = "";
			}
			foreach ($this->buttons as $class => $button) {
				$this->footer .= Html::tag("button", $button["text"], (isset($button["options"]) ? $button["options"] : []) + [
					"class" => isset($button["class"]) ? $button["class"] : "btn btn-default",
					"type" => isset($button["type"]) ? $button["type"] : "button"
				]);
			}
		}
		if ($this->id == null || $this->id == "") {
			$this->options["id"] = UniqueGenerator::generate("modal");
		} else {
			$this->options["id"] = $this->id;
		}
		parent::init();
		print Html::beginTag("div", [
			"class" => "row"
		]);
		print Html::beginTag("div", [
			"class" => $this->wrapper
		]);
	}

	/**
	 * Executes the widget
	 * @return string - The result of widget execution to be outputted.
	 */
	public function run() {
		if ($this->body != null) {
			if (is_callable($this->body)) {
				$this->body = call_user_func($this->body, $this);
			}
			print $this->body;
		}
		print Html::endTag("div");
		print Html::endTag("div");
		return parent::run();
	}
}