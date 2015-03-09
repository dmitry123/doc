<?php

namespace app\modules\admin;

use yii\base\Module;

class AdminModule extends Module {

	/**
	 * @var string - Default admin module layout, it will register asset for
	 * 	admin module and render main module layout
	 */
	public $layout = "main.php";
}