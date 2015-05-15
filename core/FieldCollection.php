<?php

namespace app\core;

use yii\base\Exception;

class FieldCollection {

	const DIRECTORY = "../fields";
	const PREFIX = "\\app\\fields\\";

	/**
	 * Get collection's singleton instance
	 * @return FieldCollection - Field collection instance
	 */
	public static function getCollection() {
		if (!self::$collection) {
			return (self::$collection = new FieldCollection());
		} else {
			return self::$collection;
		}
	}

	/**
	 * Insert field into collection
	 * @param Field $field - Field to register
	 * @throws Exception
	 */
	public function add($field) {
		$key = strtolower($field->getType());
		if (isset($this->fields[$key])) {
			throw new Exception("Field with that key already registered in collection ({$field->getType()})");
		}
		$this->fields[$key] = $field;
		$this->select[$key] = $field->getName();
	}

	/**
	 * Find field by it's key in collection
	 * @param String $key - Field's key
	 * @return Field - Field instance
	 * @throws Exception
	 */
	public function find($key) {
		$key = strtolower($key);
		if (!isset($this->fields[$key])) {
			throw new Exception("Unresolved or not implemented field type ({$key})");
		}
		return $this->fields[$key];
	}

	/**
	 * Get array with prepared array for drop down list
	 * @param array $allowed - Array with allowed types
	 * @return array - Array with keys and it's associated labels
	 */
	public function getDropDown(array $allowed = null) {
		if ($allowed == null) {
			return $this->select;
		}
		$array = [];
		foreach ($allowed as $i => $value) {
			$array[strtolower($value)] = $this->select[strtolower($value)];
		}
		return $array;
	}

	/**
	 * Get array with all registered fields
	 * @return Array - Array with registered field's instances
	 */
	public function getList() {
		return $this->fields;
	}

	private $fields = [];
	private $select = [];

	/**
	 * Don't construct that class by yourself
	 */
	private function __construct() {
		$handle = opendir(static::DIRECTORY);
		if ($handle === false) {
			throw new Exception("Can't read folder with fields");
		}
		while (($entry = readdir($handle)) !== false) {
			if ($entry != "." && $entry != "..") {
				$entry = static::PREFIX . basename($entry, ".php");
				$this->add(new $entry());
			}
		}
		closedir($handle);
	}

	private static $collection = null;
}