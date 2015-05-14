<?php

namespace app\core;

use yii\base\Object;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;

abstract class Field extends Object {

	/**
	 * Construct field, it will fetch field's
	 * unique key and it's name
	 */
	public function __construct() {
		$this->name = $this->name();
		$this->type = strtolower(
            $this->key()
        );
	}

    /**
     * Override that method to get current field instance
     * @param string $class - Name of field's class
     * @return Field - Field object
     */
    public static function field($class = null) {
		if ($class == null) {
			$class = get_called_class();
		}
        if (!isset(self::$_cached[$class])) {
            return (self::$_cached[$class] = new $class());
        } else {
            return self::$_cached[$class];
        }
    }

	/**
	 * @var array - Array with cached fields
	 * @internal
	 */
    private static $_cached = [];

	/**
	 * Render field with value or data
	 * @param ActiveForm $form - Active form for which we're rendering fields
	 * @param FormModel $model - Form's model with data configuration
	 * @return string - Just rendered field result
	 */
	public final function renderEx($form, $model) {
		return $this->render($form, $model)->render();
	}

	/**
	 * Bind render parameters to field instance
	 * @param string $key - Unique key for field (identification value)
	 * @param string $label - Field's label
	 * @param mixed $value - Any value for field
	 * @param array $data - Array with values (for DropDown lists)
	 * @param array $options - Html options for field component
	 * @return Field - Field instance
	 */
	public function bind($key, $label = "", $value = null, $data = [], $options = []) {

		assert(is_string($label), "Label must be with String type");
		assert(is_string($key), "Key must be with String type");
		assert(is_array($data), "Data must be with Array type");
		assert(is_array($options), "Options must be with Array type");

		$this->label = $label;
		$this->key = $key;
		$this->value = $value;
		$this->data = $data;
		$this->options = $options;

		$this->options += [
			"id" => $key,
			"placeholder" => $label
		];

		return $this;
	}

	/**
	 * Override that method to render field base on it's type
	 * @param ActiveForm $form - Form
	 * @param FormModel $model - Model
	 * @return ActiveField - Just rendered field result
	 */
	public abstract function render($form, $model);

	/**
	 * Override that method to return field's key
	 * @return String - Key
	 */
	public abstract function key();

	/**
	 * Override that method to return field's label
	 * @return String - Label
	 */
	public abstract function name();

	/**
	 * @return Mixed - Field's value (optional)
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return String - Field's key name
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @return String - Field's label associated with key
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return Array - Array with data for DropDown list
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @return String - Field's label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @return String - Field's type (unique key)
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param array $options - Array with fields options
	 * @return array - Array with html options
	 */
	public function getOptions($options = []) {
		return $this->options + $options;
	}

	private $value;
	private $key;
	private $type;
	private $name;
	private $data;
	private $label;
	private $options;
}