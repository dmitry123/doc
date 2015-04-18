<?php

namespace app\core;

use stdClass;
use yii\base\Component;
use yii\base\Exception;
use yii\base\Object;
use yii\helpers\ArrayHelper;

class Widget extends \yii\base\Widget {

	/**
	 * Override that method to return just rendered component
	 * @param bool $return - If true, then widget shall return rendered component else it should print to output stream
	 * @return string - Just rendered component or nothing
	 */
	public function call($return = true) {
		if ($return) {
			return $this->run();
		} else {
			print $this->run();
		}
	}

	/**
	 * Create widget and initialize it
	 * @param array $config - Widget's configuration
	 * @return Widget - Instance of widget
	 * @throws Exception
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function create($config = []) {
		$w = \Yii::createObject($config + [
				"class" => get_called_class()
			]);
		if (!$w instanceof Widget) {
			throw new Exception("Widget must be an instance of app\\core\\Widget class");
		}
		$w->_config = $config;
		$w->init();
		return $w;
	}

	/**
	 * Get widget's configuration that should be
	 * serialised before update after it's create
	 * @return array - Array with widget's configuration
	 */
	public function getConfig() {
		return $this->_config;
	}

	private $_config = [];

	/**
	 * Serialize widget's attributes by all scalar attributes and
	 * arrays or set your own array with attribute names
	 *
	 * Agreement: I hope that you will put serialized attributes
	 *    in root widget's HTML tag named [data-attributes]
	 *
	 * @param array|null $attributes - Array with attributes, which have
	 *    to be serialized, by default it serializes all scalar attributes
	 *
	 * @param array|null $excepts - Array with attributes, that should
	 *    be excepted
	 *
	 * @param array|null $string - Array with parameters that should
	 *      be converted to string value
	 *
	 * @return string - Serialized and URL encoded attributes
	 * @throws Exception
	 */
	public function getSerializedAttributes($attributes = null, $excepts = null, $string = null) {
		$params = [];
		if ($attributes === null) {
			$attributes = $this;
		}
		foreach ($attributes as $key => $value) {
			if ($excepts !== null && in_array($key, $excepts) || $key === "_config") {
				continue;
			}
			if ((is_scalar($value) || is_array($value)) && !empty($value)) {
				$params[$key] = $value;
			} else if ($string !== null && in_array($key, $string)) {
				if (is_object($value)) {
					/** @var stdClass $value */
					$params[$key] = get_class($value);
				} else if (is_scalar($value)) {
					$params[$key] = (string) $value;
				} else {
					throw new Exception("Unknown type, that can't be converted to string \"". gettype($value) ."\"");
				}
			}
		}
		return htmlspecialchars(json_encode($params));
	}

	/**
	 * Initialize widget and generate it's own
	 * unique identification number
	 */
	public function init() {
		if (!empty($this->id)) {
			return;
		}
		$this->id = UniqueGenerator::generate(
			strtolower(basename(get_called_class()))
		);
	}

	/**
	 * Create url for widget's update for current module and controller
	 * @param array $query - Additional query GET parameters
	 * @return string - Url for widget update
	 */
	public static function createUrl($query = []) {
		$controller = \Yii::$app->controller;
		$link = "";
		$module = $controller->module;
		while ($module != null && $module->module != null) {
			$link .= preg_replace("/module$/i", "/", strtolower(basename($module->className())));
			$module = $module->module;
		}
		$link .= preg_replace("/controller/i", "/", strtolower(basename($controller->className())));
		return \Yii::$app->getUrlManager()->createUrl(
			ArrayHelper::merge([ $link."widget" ], $query)
		);
	}

	/**
	 * Run widget to return just rendered content
	 * @return string - Just rendered content
	 */
	public function run() {
		return $this->render(preg_replace("/[.*~\\/]$/", __CLASS__, ""), []);
	}
}