<?php

namespace app\models;

use app\core\ActiveRecord;

class Log extends ActiveRecord {

	const ACTION_UNKNOWN     = 0x0000;
	const ACTION_NEW_FILE    = 0x0001;
	const ACTION_UPDATE_FILE = 0x0002;
	const ACTION_DROP_FILE   = 0x0003;

	/**
	 * Get table name from class path with namespace
	 * @return string - Name of table from class's name
	 */
	public static function tableName() {
		return "doc.log";
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
			"LogAction" => [
				Log::ACTION_UNKNOWN => "Неизвестное действие",
				Log::ACTION_NEW_FILE => "Добавление файла",
				Log::ACTION_UPDATE_FILE => "Редактирование файла",
				Log::ACTION_DROP_FILE => "Удаление файла"
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
			"LogAction" => "Тип действия",
		];
	}
}