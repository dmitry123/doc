<?php

namespace app\models;

use app\core\ActiveRecord;

class Access extends ActiveRecord {

	const MODE_DENIED = 0x00;
	const MODE_READ   = 0x01;
	const MODE_WRITE  = 0x02;
	const MODE_ALL    = 0xff;

	/**
	 * Get table name from class path with namespace
	 * @return string - Name of table from class's name
	 */
	public static function tableName() {
		return "core.access";
	}

	/**
	 * Override that method to return an array
	 * with types's data, where array's key is
	 * type name and value is array with fields
	 * in format [key => value]
	 *
	 * @return array - Array with types keys and items
	 */
	public static function listTypeItems() {
		return [
			"AccessMode" => [
				Access::MODE_DENIED => "Закрыт",
				Access::MODE_READ => "Чтение",
				Access::MODE_WRITE => "Запись",
				Access::MODE_ALL => "Полный"
			],
		];
	}

	/**
	 * Override that method to return array
	 * with types labels, it uses for different
	 * localization models, where format is [key => label]
	 *
	 * @return array - Array with types localizations
	 */
	public static function listTypeLabels() {
		return [
			"AccessMode" => "Уровень доступа",
		];
	}
}