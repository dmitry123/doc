<?php

namespace app\modules\admin;

use app\core\Module;

class AdminModule extends Module {

	/**
	 * Define behaviors for admin module
	 * @return array - Array with configurations
	 */
	public function behaviors() {
		return [
			"access" => [
				"class" => "app\\filters\\AccessFilter",
				"rules" => [
					"roles" => [
						"admin",
						"super"
					]
				],
			]
		];
	}

	/**
	 * @var string - Default admin module layout, it will register asset for
	 * 	admin module and render main module layout
	 */
	public $layout = "main.php";
}