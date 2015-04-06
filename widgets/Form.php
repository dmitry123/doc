<?php

namespace app\widgets;

use app\core\FormModel;
use app\core\Widget;
use app\core\FieldCollection;
use app\core\FormModelAdapter;
use Yii;
use yii\base\ErrorException;
use yii\db\Query;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class Form extends Widget {

	/**
	 * @var string - DOM identification value
	 */
    public $id = null;

	/**
	 * @var string - Path to url to execute
	 */
    public $url = null;

    /**
     * @var FormModel - Form's model
     */
    public $model = null;

	/**
	 * @var bool - False to display labels
	 */
	public $labels = true;

	/**
	 * @var array - Extra form HTML options
	 */
	public $options = [];

	/**
	 * @var string - Form wrapper with submit button
	 */
	public $wrapper = null;

	/**
	 * @var array - Array with submit button configuration
	 */
	public $button = null;

	/**
	 * @var string - Default form class
	 */
	public $class = "col-xs-12";

    /**
     * Override that method to return just rendered component
     * @throws ErrorException
     * @return string - Just rendered component or nothing
     */
    public function run() {
        if (is_array($this->model)) {
            $config = [];
            foreach ($this->model as $i => $model) {
                if ($this->test($model)) {
                    $config += $model->getConfig();
                }
            }
            $this->model = new FormModelAdapter($config);
        } else {
            $this->test($this->model);
        }
        return $this->render("Form", [
			"self" => $this,
            "model" => $this->model,
			"id" => $this->id,
			"url" => $this->url
        ]);
    }

    /**
     * Test model for LFormModel inheritance and not null
     * @param Mixed $model - Model which must extends LFormModel
     * @return bool - True if everything ok
     * @throws ErrorException
     */
    private function test($model) {
        if (!$model || !($model instanceof FormModel)) {
            throw new ErrorException("Unresolved model field or form model isn't instance of LFormModel ".(int)$model);
        }
        return true;
    }

    /**
     * Format every data field with specific format, it will get data format field's
     * from model
     * @param String $format - String with data format, for example ${id} or ${surname}
     * @param Array $data - Array with data to format
     */
	public static function format($format, array& $data) {
        foreach ($data as $i => &$value) {
			if (is_object($value)) {
				$model = clone $value;
			} else {
				$model = $value;
			}
            $matches = [];
            if (is_string($format)) {
                preg_match_all("/%\\{([a-zA-Z_0-9]+)\\}/", $format, $matches);
                $value = $format;
                if (count($matches)) {
                    foreach ($matches[1] as $m) {
                        $value = preg_replace("/%\\{([({$m})]+)\\}/", $model[$m], $value);
                    }
                }
            } else if (is_callable($format)) {
                $value = $format($value);
            }
        }
    }

    /**
     * Fetch data for current table configuration, it will
     * throw an exception if value or name won't be defined, where
     *  + key - Name of table's primary key
     *  + value - Name of table's value to display
     *  + name - Name of displayable table
     * @param array $table - Array with table configuration
     * @return array - Array with prepared data
     * @throws ErrorException
     */
    public static function fetch($table) {
        if (!isset($table["name"]) && !isset($table["value"])) {
            throw new ErrorException("AutoTable configuration requires key, value and name");
        }
        if (!isset($table["key"])) {
            $table["key"] = "id";
        }
        $key = $table["key"];
        $value = $table["value"];
        $data = (new Query())
            ->select("$key, $value")
            ->from($table["name"])
            ->all();
        $result = [];
        if (isset($table["format"])) {
            foreach ($data as $row) {
                $result[$row[$key]] = $row;
            }
            self::format($table["format"], $result);
        } else {
            foreach ($data as $row) {
                $result[$row[$key]] = $row[$value];
            }
        }
        return $result;
    }

	/**
	 * Get configuration option or it's default value
	 * @param array $config - Array with configuration
	 * @param string $key - Name of key to get
	 * @param mixed $default - Default value
	 * @return mixed - It's value or default
	 */
	private function option(array& $config, $key, $default = null) {
		if (isset($config[$key])) {
			return $config[$key];
		} else {
			return $default;
		}
	}

	/**
	 * Prepare field for render, it will build it's configuration
	 * and return Field instance
	 * @param string $key - Name of field's key (type)
	 * @return \app\core\Field - Field instance
	 */
	public function prepare($key) {
		$config = $this->model->getConfig($key);
		$options = $this->option($config, "options", []);
		if (isset($config["update"])) {
			$options["data-update"] = $config["update"];
		}
		if (isset($config["table"])) {
			$data = $this->fetch($config["table"]);
		} else {
			$data = [];
		}
		$type = $this->option($config, "type", "text");
		$value = $this->option($config, "value");
		$label = $this->option($config, "label", "");
		return FieldCollection::getCollection()->find($type)
			->bind($key, $label, $value, $data, $options);
	}

    /**
     * That function will render all form elements based on it's type
     * @param ActiveForm $form - Active form instance
     * @param string $key - Field name
     * @return string - Result string
     * @throws ErrorException - If field's type hasn't been implemented in renderer
     */
    public function renderField($form, $key) {
		return $this->prepare($key)->render($form, $this->model);
    }

	/**
	 * Render form control element
	 * @param string $class - Main class name
	 * @param array $control - Array with single control configuration
	 * @return string - Rendered element
	 */
	public function renderControl($class, array $control) {
		return Html::tag(isset($control["tag"]) ? $control["tag"] : "button", isset($control["text"]) ? $control["text"] : "", [
			"class" => (isset($control["class"]) ? $control["class"] : "btn btn-primary") . " $class",
		] + isset($control["options"]) ? $control["options"] : []);
	}

    /**
     * Check model's type via it's configuration
     * @param string $key - Name of native key to check
     * @param string $type - Type to test
     * @return bool - True if type if equal else false
     */
    public function checkType($key, $type) {
        $config = $this->model->getConfig()[$key];
        if (!isset($config["type"])) {
            $config["type"] = "text";
        }
        return strtolower($config["type"]) == strtolower($type);
    }

	/**
	 * Check if field has hidden property
	 * @param string $key - Name of native key to check
	 * @return bool - True if field must be hidden
	 */
	public function getForm($key) {
		$config = $this->model->getConfig()[$key];
		if (!isset($config["form"])) {
			return false;
		}
		return $config["form"];
	}

    /**
     * Check if field has hidden property
     * @param string $key - Name of native key to check
     * @return bool - True if field must be hidden
     */
    public function isHidden($key) {
        $config = $this->model->getConfig()[$key];
		if (isset($config["hidden"])) {
			return true;
		}  else if (isset($config["type"]) && !strcasecmp($config["type"], "hidden")) {
            return true;
        } else {
			return false;
		}
    }
} 