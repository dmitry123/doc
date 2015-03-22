<?php

namespace app\core;

class Module extends \yii\base\Module {

	/**
	 * @var string - Module name in russian
	 */
	public $name;

	/**
	 * @var string - Glyphicon class
	 */
	public $icon;

	/**
	 * @var array - Allowed roles for that module
	 */
	public $roles = null;
}