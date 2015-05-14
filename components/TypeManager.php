<?php

namespace app\components;

class TypeManager {

	private $_types = [
		"boolean" => [
			"label" => "Логический"
		],
		"date" => [
			"label" => "Дата"
		],
		"dropdown" => [
			"label" => "Выпадающий список"
		],
		"multiple" => [
			"label" => "Множественный выбор"
		],
		"email" => [
			"label" => "Почтовый ящик"
		],
		"text" => [
			"label" => "Текстовое поле"
		],
		"file" => [
			"label" => "Файл"
		],
		"hidden" => [
			"label" => "Невидимое поле"
		],
		"number" => [
			"label" => "Число"
		],
		"password" => [
			"label" => "Пароль"
		],
		"phone" => [
			"label" => "Телефон"
		],
		"radio" => [
			"label" => "Радио"
		],
		"textarea" => [
			"label" => "Текстовая область"
		],
	];

	/**
	 * Get singleton type manager's
	 * instance
	 *
	 * @return TypeManager class instance
	 */
	public static function getManager() {
		if (self::$_manager == null) {
			return self::$_manager = new TypeManager();
		} else {
			return self::$_manager;
		}
	}

	/**
	 * Get array with type manager types, you can
	 * override, but don't forget to invoke parent
	 * classes, like [parent::getTypes() + []]
	 *
	 * @return array with types for current class
	 */
	public function getTypes() {
		return $this->_types;
	}

	/**
	 * Get array with dropdown list for HTML select
	 * element
	 *
	 * @return array with default list types optimized
	 * 	for HTML select element
	 */
	public function listTypes() {
		$list = [];
		foreach ($this->_types as $key => $value) {
			$list[$key] = $value["label"];
		}
		return $list;
	}

	/**
	 * Locked, use [@see getManager] method to get
	 * single instance of TypeManager class
	 */
	private function __construct() {
		/* Locked */
	}

	private static $_manager = null;
}