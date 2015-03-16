<?php

namespace app\core;

use yii\base\ErrorException;
use yii\base\Model;

abstract class FormModel extends Model {

	/**
	 * Override that variable to return list default
	 * validators aliases and it's replacement
	 * @var array - Array with replacements
	 * @see replace
	 */
	protected $replace = [
		"required" => "\\app\\validators\\RequiredValidator"
	];

	/**
	 * Array with configuration (for future optimization)
	 * @var array - Array with configuration
	 * @deprecated - Unused
	 */
	protected $config = [];

	/**
	 * Construct form model instance with scenario
	 * @param string $scenario name of the scenario that this model is used in.
	 * See {@link CModel::scenario} on how scenario is used by models.
	 * @see getScenario
	 */
	public function __construct($scenario = "") {
		$this->setScenario($scenario);
	}

	/**
	 * Override that method to return config. Config should return array associated with
	 * model's variables. Every field must contains 3 parameters:
	 *  + label - Variable's label, will be displayed in the form
	 *  + type - Input type (@see Form::renderField())
	 *  + rules - Basic form's Yii rules, such as 'required' or 'numeric' etc
	 * @return Array - Model's config
	 */
	public abstract function config();

	/**
	 * Get form model configuration or configuration for one key, if key is null
	 * then it will return configuration for all model
	 * @param string|null $key - Get configuration for some field by it's key
	 * @return array|null - Model configuration
	 * @throws ErrorException
	 */
	public function getConfig($key = null) {
		if ($this->_config == null) {
			$this->_config = $this->config();
			$this->buildConfig();
		}
		if ($key != null) {
			if (!isset($this->_config[$key])) {
				throw new ErrorException("Can't resolve configuration for \"$key\" key");
			}
			return $this->_config[$key];
		} else {
			return $this->_config;
		}
	}

	/**
	 * Returns attribute values.
	 * @param array $names list of attributes whose value needs to be returned.
	 * Defaults to null, meaning all attributes listed in [[attributes()]] will be returned.
	 * If it is an array, only the attributes in the array will be returned.
	 * @param array $except list of attributes whose value should NOT be returned.
	 * @return array attribute values (name => value).
	 */
	public function getAttributes($names = null, $except = []) {
		$values = [];
		if ($names === null) {
			$names = $this->attributes();
		}
		foreach ($names as $name) {
			$values[$name] = $this->$name;
		}
		foreach ($except as $name) {
			unset($values[$name]);
		}
		foreach ($values as $key => &$v) {
			if (empty($v)) {
				unset($values[$key]);
			}
		}
		return $values;
	}

	/**
	 * Override that method to return list with replacements, don't
	 * forget parents replacements
	 * @return array - Array with rules replacements
	 */
	public function replace() {
		return $this->replace;
	}

	/**
	 * Override that method to return additional rule configuration, like
	 * scenario conditions or others
	 * @return array - Array with rule configuration
	 */
	public function backward() {
		return [
			[ "id", "required", "on" => [ "update", "delete" ] ]
		];
	}

	/**
	 * That function will check model's field for valid for drop down list
	 * @param string $field - Field's name
	 * @return bool - True if field can be used for data receive from db
	 */
	public function isActive($field) {
		return isset($this->$field) && $this->$field && $this->$field != -1;
	}

	/**
	 * Check is field looks like drop down list
	 * @param $field - Name of field to test
	 * @return bool - True if field is drop down list
	 */
	public function isDropDown($field) {
		if (!$this->_config) {
			$this->_config = $this->config();
		}
		if (!isset($this->_config[$field]) || (!isset($this->_config[$field]["type"]))) {
			return false;
		}
		$type = strtolower($this->_config[$field]["type"]);
		return $type == "dropdown" || $type == "multiple";
	}

	/**
	 * Build form from models configuration
	 * @param array|null $config - Array with model's configuration
	 */
	private function buildConfig($config = null) {
		if ($this->_rules && $this->_labels && $this->_types) {
			return;
		}
		if ($config == null) {
			$config = $this->getConfig();
		}
		$this->_rules = [];
		$this->_labels = [];
		$this->_types = [];
		$this->_strong = [];
		foreach ($config as $key => &$field) {
			if (isset($field["label"])) {
				$this->_labels[$key] = $field["label"];
			} else {
				$this->_labels[$key] = "";
			}
			if (isset($field["rules"])) {
				$this->_rules = $this->buildRules($field["rules"], $key);
			}
			if (isset($field["types"])) {
				$this->_types[$key] = $field["types"];
			} else {
				$this->_types[$key] = "";
			}
			if (isset($field["value"])) {
				$this->$key = $field["value"];
			} else {
				$this->$key = null;
			}
		}
		$this->buildBackward();
	}

	/**
	 * Build backward configuration
	 */
	public function buildBackward() {
		$this->_backward = $this->backward();
		foreach ($this->_backward as $i => &$b) {
			if (isset($b[1]) && $b[1] == "hide") {
				$key = $b[0];
				if (is_array($key) && $this->checkScenario($b["on"])) {
					foreach ($key as $r) {
						$this->_config[$r]["type"] = "hidden";
					}
				} else if ($this->checkScenario($b["on"]) && is_string($key)) {
					$this->_config[$key]["type"] = "hidden";
				}
				array_splice($this->_backward, $i, 1);
			}
		}
	}

	/**
	 * Check if current model has been loaded with that
	 * one of that scenario
	 * @param array|string $scenario - Scenario name or array with names
	 * @return bool - True if scenario exists
	 */
	private function checkScenario($scenario) {
		if (is_array($scenario)) {
			foreach ($scenario as $s) {
				if (!strcasecmp($s, $this->scenario)) {
					return true;
				}
			}
		} else {
			return !strcasecmp($scenario, $this->scenario);
		}
		return false;
	}

	/**
	 * Find and replace validation rule for fields configuration
	 * @param string|array $rule - Rule options
	 * @return array|string - Sent rule options
	 */
	private function replaceRules(&$rule) {
		if (is_string($rule)) {
			foreach ($this->replace as $old => $new) {
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

	/**
	 * Build rules array for CFormModel
	 * @param string|array $rules - Array with rules or simple string with imploded by comma rules
	 * @param string $key - Name of rules key
	 * @return array - Array with built rules
	 */
	private function buildRules($rules, $key) {
		$container = $this->_rules;
		if (is_string($rules)) {
			foreach (explode(",", $rules) as $i => $rule) {
				$rule = trim($rule);
				$this->replaceRules($rule);
				if (!isset($container[$rule])) {
					$container[$rule] = [];
				}
				array_push($container[$rule], $key);
			}
		} else if (is_array($rules)) {
			$this->_strong[] = array_merge([$key], $this->replaceRules($rules));
		}
		return $container;
	}

	/**
	 * Get data for key, that method - is result or optimization, when
	 * all data stuff was in basic configuration
	 * @param string $key - Name of unique field's identification number
	 * @return array - Array with data or null, if method hasn't been declared
	 * @deprecated - Use table configuration (optimized and automatized)
	 */
	public function getKeyData($key) {
		$method = "get".self::changeNotation($key);
		if (method_exists($this, $method)) {
			return $this->$method();
		} else {
			return null;
		}
	}

	/**
	 * That function will change variable's notation from database's to
	 * classic PHP without '_' as delimiter. For example, name guide_id will
	 * be converted to GuideId
	 * @param string $name - Name to change
	 * @param bool $startWithUpper - Set that flag to false to set first letter to lower case
	 * @return string - Formatted string
	 */
	public static function changeNotation($name, $startWithUpper = true) {
		$result = "";
		foreach (explode("_", $name) as $word) {
			$result .= strtoupper(substr($word, 0, 1)) . substr($word, 1);
		}
		if (!$startWithUpper) {
			$result[0] = strtolower($result[0]);
		}
		return $result;
	}

	/**
	 * Convert array with array models to list data, it will be faster
	 * and easier in use then CHtml::listData method
	 * @param array $models - Array with models
	 * @param string $id - Name of select value
	 * @param string $value - Name of select option text
	 * @return array - Array with result map
	 * @see CHtml::listData
	 */
	public static function listData($models, $id, $value) {
		$result = [];
		foreach ($models as &$model) {
			$result[$model[$id]] = $model[$value];
		}
		return $result;
	}

	/**
	 * Get form model's rules associated with fields names
	 * @return Array - Rules for form's mode;
	 */
	public function rules() {
		if ($this->_cached != null) {
			return $this->_cached;
		}
		if (!$this->_rules) {
			$this->buildConfig();
		}
		$result = [];
		foreach ($this->_rules as $rule => $rules) {
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
		return $this->_cached = array_merge($result, array_merge($this->_strong,
			$this->replaceRules($this->_backward)
		));
	}

	private $_cached = null;

	/**
	 * Get form model's labels
	 * @return Array - Array with labels associated with fields names
	 */
	public function attributeLabels() {
		if (!$this->_labels) {
			$this->buildConfig();
		}
		return $this->_labels;
	}

	protected $_rules = null;
	protected $_strong = null;
	protected $_labels = null;
	protected $_types = null;
	protected $_config = null;
	protected $_data = null;
	protected $_backward = null;
} 