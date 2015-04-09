<?php

namespace app\models;

use app\core\ActiveRecord;

class Phone extends ActiveRecord {

	const TYPE_CITY   = 0x0000;
	const TYPE_MOBILE = 0x0001;
	const TYPE_JOB    = 0x0002;

	/**
	 * Get table name from class path with namespace
	 * @return string - Name of table from class's name
	 */
	public static function tableName() {
		return "core.phone";
	}

	/**
	 * Override that method to return an array
	 * with types's data, where array's key is
	 * type name and value is array with fields
	 * in format [key => value]
	 *
	 * @return array - Array with types keys and items
	 */
	public static function typeItems() {
		return [
			"PhoneType" => [
				Phone::TYPE_CITY => "Городской",
				Phone::TYPE_MOBILE => "Мобильный",
				Phone::TYPE_JOB => "Служебный"
			]
		];
	}

	/**
	 * Override that method to return array
	 * with types labels, it uses for different
	 * localization models, where format is [key => label]
	 *
	 * @return array - Array with types localizations
	 */
	public static function typeLabels() {
		return [
			"PhoneType" => "Тип телефона"
		];
	}
}