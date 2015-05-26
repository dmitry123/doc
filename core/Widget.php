<?php

namespace app\core;

use app\widgets\Modal;
use yii\base\Exception;

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
		return false;
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
			throw new Exception("Widget must be an instance of [app\\core\\Widget] class");
		}
		$w->_config = $config;
		return $w;
	}

    /**
     * Wrap your widget with bootstrap modal window
     *
     * @param $config array with basic widget
     *  configuration
     *
     * @param $modal array with widget configuration
     *  for modal window class
     *
     * @return string with modal rendered content
     */
    public static function modal($config = [], $modal = []) {
        return Modal::widget([
                "body" => static::create($config)
            ] + $modal);
    }

    /**
     * Use that method to require some widget's attribute and
     * to avoid extra conditions
     *
     * @param $key string name of widget's field
     * @return mixed value of this attribute
     *
     * @throws Exception
     */
    public function requireAttribute($key) {
        if (!isset($this->$key) || empty($this->$key)) {
            throw new Exception("Widget [". get_called_class() ."] attribute \"$key\" can't be empty");
        } else {
            return $this->$key;
        }
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
	public function getAttributes($attributes = null, $excepts = [], $string = null) {
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
					/** @var \stdClass $value */
					$params[$key] = get_class($value);
				} else if (is_scalar($value)) {
					$params[$key] = (string) $value;
				} else {
					throw new Exception("Unknown type can't be converted to string \"". gettype($value) ."\"");
				}
			}
		}
		return htmlspecialchars(json_encode($params));
	}

	/**
	 * Returns the ID of the widget.
	 * @param boolean $autoGenerate - Whether to generate an ID if it is not set previously
	 * @return string - ID of the widget.
	 */
	public function getId($autoGenerate = true) {
		if ($autoGenerate && $this->id === null) {
			$class = strtolower(get_called_class());
			if (($p = strrpos($class, "\\")) !== false) {
				$class = substr($class, $p + 1);
			}
			return $this->id = UniqueGenerator::generate($class);
		} else {
			return $this->id;
		}
	}

	/**
	 * Create url for widget's update for current module and controller
	 * @param array $query - Additional query GET parameters
	 * @return string - Url for widget update
	 */
	public static function createUrl($query = []) {
		$url = preg_replace("/\\/[a-z0-9]*$/i", "/widget",
			preg_replace("/\\?.*$/", "", \Yii::$app->getRequest()->getUrl())
		);
		if (!empty($query)) {
			$url .= "?";
		}
		foreach ($query as $key => $value) {
			$url .= urlencode($key."=".$value."&");
		}
		return preg_replace("/&\\s$/", "", $url);
	}

	/**
	 * Run widget to return just rendered content
	 * @return string - Just rendered content
	 */
	public function run() {
		return $this->render(preg_replace("/[.*~\\/]$/", __CLASS__, ""), []);
	}
}