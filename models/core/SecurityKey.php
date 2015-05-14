<?php

namespace app\models\core;

use app\components\ActiveRecord;

class SecurityKey extends ActiveRecord {

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "numerical"
			],
			"key" => [
				"label" => "Ключ безопасности",
				"type" => "text",
				"rules" => "required"
			]
		];
	}

	public function rules() {
		return [
			[ "key", "string", "max" => 128 ]
		];
	}

	public static function tableName() {
		return "core.security_key";
	}
}