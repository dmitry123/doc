<?php

namespace app\core;

use yii\base\Exception;
use yii\base\Object;

abstract class Ext extends Object {

	use ClassTrait;

	/**
	 * @var string identification number of current extension, don't
	 * 	change it, it won't take any effect (generates automatically)
	 */
	public $id = null;

	/**
	 * @var string name of module class for which
	 * 	that extension should be appended.
	 *
	 * It uses to generate path to your extension without
	 * namespaces
	 */
	public $module = "basic";

	/**
	 * Override that method to load your extension from
	 * widget or another view file to return it's content
	 *
	 * @return string just rendered content which your
	 * 	extension component produces
	 */
	abstract function load();

	/**
	 * Override that method to provider some actions with
	 * extension data saving
	 *
	 * @throws Exception if extension saving not
	 * 	supported
	 */
	public function save() {
		throw new Exception("That extension \"". get_called_class() ."\" doesn't support saving");
	}
}