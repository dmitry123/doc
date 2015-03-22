<?php

namespace app\modules\doc;

use app\core\Module;

class DocModule extends Module {

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
						"teacher",
						"director",
						"manager",
						"super",
					]
				],
			]
		];
	}
}