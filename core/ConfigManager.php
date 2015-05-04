<?php

namespace app\core;

use yii\base\Exception;

class ConfigManager {

	/**
	 * Override that method to return list with replacements, don't
	 * forget parents replacements
	 * @return array - Array with rules replacements
	 */
	public function replace() {
		return [
			"required" => "\\app\\validators\\RequiredValidator"
		];
	}

	public $labels = [];
	public $types = [];
	public $rules = [];
	public $tables = [];
	public $attrs = [];

	public static function createManager( array $config = null) {
		return new static($config);
	}

	public function __construct(array $config = null) {
		if (!empty($config)) {
			$this->build($config);
		}
	}

	public function build(array $config) {
		if ($this->_config != null) {
			return $this->_config;
		}
		foreach ($config as $key => &$column) {
			if (!isset($column["label"]) || !isset($column["type"])) {
				throw new Exception("ActiveRecord column's configuration for \"$key\" requires [label] and [type] fields");
			} else {
				if (isset($column["attributes"])) {
					$this->attrs[$key] = $column["attributes"];
				}
				$this->labels[$key] = $column["label"];
				$this->types[$key] = $column["types"];
			}
			if (isset($column["rules"])) {
				$this->buildRule($key, $column["rules"]);
			}
			if (isset($column["table"])) {
				$this->tables[$key] = $this->buildTable($column["tables"]);
			}
		}
		return $this->_config = $config;
	}

	public function finalize() {
		if ($this->_cached != null) {
			return $this->_cached;
		} else if (!$this->_config) {
			throw new Exception("Invoke [build] method first before finalizing");
		}
		$result = [];
		foreach ($this->rules as $rule => $rules) {
			if (is_string($rules)) {
				array_push($result, [
					implode(", ", $rules), $rule
				]);
			} else {
				array_push($result, [
					$rules, $rule
				]);
			}
		}
		return $this->_cached = $result;
	}

	public function reset(array $config = null) {
		$this->_config = null;
		foreach ($this as $key => &$value) {
			if (is_array($value)) {
				$value = [];
			}
		}
		if ($config != null) {
			return $this->build($config);
		} else {
			return null;
		}
	}

	public function getLabel($key) {
		return isset($this->labels[$key]) ? $this->labels[$key] : null;
	}

	public function getType($key) {
		return isset($this->types[$key]) ? $this->types[$key] : null;
	}

	public function getRule($key) {
		return isset($this->rules[$key]) ? $this->rules[$key] : null;
	}

	public function getTable($key) {
		return isset($this->tables[$key]) ? $this->tables[$key] : null;
	}

	public function getAttributes($key) {
		return isset($this->attrs[$key]) ? $this->attrs[$key] : null;
	}

	protected function buildRule($key, array $rules) {
		if (!is_string($rules)) {
			throw new Exception("Rule must be string value, use [rules] method for class Yii rules");
		}
		foreach (explode(",", $rules) as $i => $rule) {
			$rule = trim($rule);
			$this->replaceRules($rule);
			if (!isset($container[$rule])) {
				$container[$rule] = [];
			}
			array_push($container[$rule], $key);
		}
		return $this->rules;
	}

	protected function buildTable(array $rules) {
		return $rules;
	}

	/**
	 * Find and replace validation rules for fields configuration
	 * @param string|array $rule - Rule options
	 * @return array|string - Sent rule options
	 */
	private function replaceRules(&$rule) {
		if (is_string($rule)) {
			foreach ($this->replace() as $old => $new) {
				$rule = str_replace($old, $new, $rule);
			}
			$result = [];
			foreach (explode(",", $rule) as $r) {
				$result[] = trim($r);
			}
			$rule = implode(",", $result);
		} else if (is_array($rule)) {
			foreach ($rule as &$r) {
				$this->replaceRules($r);
			}
		}
		return $rule;
	}

	private $_config = null;
	private $_cached = null;
}