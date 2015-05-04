<?php

namespace app\models\core;

use app\core\ActiveRecord;
use Exception;

class Phone extends ActiveRecord {

	const TYPE_CITY   = 0x0001;
	const TYPE_MOBILE = 0x0002;
	const TYPE_JOB    = 0x0003;

	public function configure() {
		return [
			"id" => [
				"label" => "Идентификатор",
				"type" => "hidden",
				"rules" => "numerical"
			],
			"region" => [
				"label" => "Регион",
				"type" => "number",
				"rules" => "required, numerical"
			],
			"code" => [
				"label" => "Код оператора",
				"type" => "number",
				"rules" => "required, numerical"
			],
			"phone" => [
				"label" => "Телефон",
				"type" => "text",
				"rules" => "required"
			],
			"type" => [
				"label" => "Тип телефона",
				"type" => "DropDown",
				"source" => "listTypes",
				"rules" => "required, numerical"
			]
		];
	}

	public function rules() {
		return [
			[ "phone", "string", "max" => 30 ]
		];
	}

	public static function tableName() {
		return "core.phone";
	}

	/**
	 * List array with phone types with it's label
	 * @return array with phone types
	 */
	public static function listTypes() {
		return [
			Phone::TYPE_CITY => "Городской",
			Phone::TYPE_MOBILE => "Мобильный",
			Phone::TYPE_JOB => "Служебный"
		];
	}

	/**
	 * Register phone number in database by string in
	 * next format [+X (XXX) XXX-XX-XX]
	 *
	 * @param $phone string with full phone number that will
	 * 	be divide into 3 parts (region, code, phone)
	 *
	 * @return bool true on success and false on failure
	 * @throws Exception if string doesn't match pattern
	 */
	public static function registerHelper($phone) {
		if (!preg_match(static::REGEXP, $phone, $matches) || count($matches) != 4) {
			throw new Exception("Phone ($phone) doesn't match pattern [".static::REGEXP."]");
		}
		$phone = new static([
			"region" => $matches[1],
			"code" => $matches[2],
			"phone" => preg_replace('/[^0-9]*/', "", $matches[3]),
			"type" => static::TYPE_MOBILE
		]);
		if (!$phone->save(true)) {
			return false;
		} else {
			return $phone;
		}
	}

	const REGEXP = '/^\+?([0-9]{1,4})\s*\(([0-9]{1,5})\)\s*([0-9\s-]{3,})\s*$/';
}