<?php

namespace app\core;

use yii\base\ErrorException;
use yii\base\Model;

abstract class FormModel extends Model {

	/**
	 * Override that method to return new instance of
	 * active record class which associated with that form
	 *
	 * @return ActiveRecord instance of table model class
	 */
	public abstract function createActiveRecord();

	/**
	 * Get instance of active record class, it caches
	 * instance automatically, so you can revoke it
	 * many times
	 *
	 * @return ActiveRecord instance of table model class
	 */
	public function getActiveRecord() {
		if ($this->_model == null) {
			return $this->_model = $this->createActiveRecord();
		} else {
			return $this->_model;
		}
	}

	/**
	 * Create new instance of form model class with
	 * custom scenario
	 *
	 * @param $scenario string name of form's scenario
	 * @param $config array with class configuration
	 *
	 * @return static instance of new form model class
	 */
	public static function createWithScenario($scenario = Model::SCENARIO_DEFAULT, $config = []) {
		$var = new static($config);
		if ($scenario != Model::SCENARIO_DEFAULT) {
			$var->setScenario($scenario);
		}
		return $var;
	}

	/**
	 * Clone form model and return new instance with
	 * new scenario
	 * @param string $scenario - Scenario
	 * @return FormModel - New form model instance
	 */
	public function copyOf($scenario = Model::SCENARIO_DEFAULT) {
		$clone = clone $this;
		$clone->setScenario($scenario);
		return $clone;
	}

	/**
	 * Return array with rules for this form model, it
	 * can be extended in sub classes, but don't forget
	 * to invoke parent method
	 *
	 * @return array with database model rules
	 */
	public function rules() {
		return $this->getActiveRecord()->getManager()->finalize();
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
	 * Get form model's labels
	 * @return Array - Array with labels associated with fields names
	 */
	public function attributeLabels() {
		return $this->getActiveRecord()->attributeLabels();
	}

	private $_model = null;
} 