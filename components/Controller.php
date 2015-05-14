<?php

namespace app\components;

use app\components\widgets\Form;
use yii\base\ErrorException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\web\Session;

abstract class Controller extends \yii\web\Controller {

	use ClassTrait;

	public function actions() {
		return [
			'error' => [
				'class' => 'app\components\ErrorAction',
			]
		];
	}

	/**
	 * That method will help to remove row from an array. Why do you need it? For example you
	 * have table with rows and also you have user interface with forms to edit/add new rows
	 * into that table. After sending request for data update you can remove all stuff
	 * from db and reappend rows but you might crash foreign keys, so you can use
	 * basic method <code>LModel::findIds</code> to fetch list with identification
	 * numbers (primary keys) and look though every received row and invoke that method. The
	 * result array of your iterations will be array with row's ids to remove from db.
	 *
	 * <pre>
	 * // Fetch rows identifications from database by some condition
	 * $rows = MyTable::model()->findIds();
	 *
	 * // look though each row in received data
	 * foreach ($_GET['data'] as $row) {
	 *     self::arrayInDrop($row, $rows);
	 *     // provide your actions with row
	 * }
	 *
	 * // remove remaining rows
	 * foreach ($rows as $id) {
	 *     MyTable::model()->deleteByPk($id);
	 * }
	 * </pre>
	 *
	 * @param $row mixed - Current row with "id" field
	 * @param $rows array - Array with rows
	 * @param string $id - Primary key name
	 * @see LModel::findIds
	 */
	public static function arrayInDrop($row, array &$rows, $id = "id") {
		if (is_array($row)) {
			if (!isset($row[$id])) {
				return ;
			}
			$id = $row[$id];
		} else {
			if (!isset($row->$id)) {
				return ;
			}
			$id = $row->$id;
		}
		if ($id && ($index = array_search(intval($id), $rows)) !== false) {
			array_splice($rows, $index, 1);
		}
	}

	/**
	 * Render some view with specific layout
	 * @param string $layout - Default view's layout
	 * @param string $view - Page to render
	 * @param array $parameters - View parameters
	 * @return string - Just rendered content
	 */
	public function render2($layout, $view, $parameters = []) {
		$this->layout = $layout;
		return $this->render($view, $parameters);
	}

	/**
	 * Decode url and convert it into array
	 * @param string $url - Encoded url
	 * @param string $form - Form's name
	 * @return array - Array with values
	 */
	public function decode($url, &$form = "") {
		$result = [];
		if (!is_string($url)) {
			return null;
		}
		$url = urldecode($url);
		$array = explode("&", $url);
		foreach ($array as $str) {
			$match = [];
			preg_match("/\\[[a-zA-Z0-9_]+\\]/", $str, $match);
			if (!count($match)) {
				continue;
			}
			$value = substr($str, strpos($str, "=") + 1);
			if ($value === false) {
				$value = "";
			}
			if (!is_string($form) || !strlen($form)) {
				$form = substr($str, 0, strpos($str, "["));
			}
			$result[substr($match[0], 1, strlen($match[0]) - 2)] = $value;
		}
		return $result;
	}

	/**
	 * Decode form's url, convert it to array try to validate it's form
	 * @param string $form - String with encode form's url
	 * @param bool $error - Set that flag to false to store errors in array
	 * @param string $name - Form's name will be in that field
	 * @param string $scenario - Form's module usage scenario
	 * @return FormModel - Form's model with attributes
	 * @throws ErrorException
	 */
	public function getUrlForm($form, $error = true, $scenario = null, &$name = "") {
		if (!is_string($form)) {
			throw new ErrorException("Form's model must be serialized form string");
		}
		$array = $this->decode($form, $name);
		$name = "\\app\\forms\\" . $name;
		$form = new $name($scenario);
		if (!($form instanceof FormModel)) {
			throw new ErrorException("Form must be instance of LFormModel class");
		}
		$form->attributes = $array;
		foreach ($array as $i => $value) {
			$form->$i = $value;
		}
		if (!$form->validate()) {
			if ($error) {
				$this->postValidationErrors($form);
			} else {
				$this->errors += $form->getErrors();
			}
		}
		return $form;
	}

	/**
	 * Post validation errors and return as JSON response
	 * @param Model $model - Model with errors
	 */
	public function postValidationErrors($model = null) {
		if ($model != null) {
			$errors = [];
			foreach ($model->getErrors() as $key => $value) {
				$errors[ClassTrait::createID($model->className())."-".$key] = $value;
			}
		} else {
			$errors = $this->errors;
		}
		$this->leave([
			"message" => "Произошли ошибки во время валидации формы",
			"errors" => $errors,
			"error" => "form",
			"status" => false
		]);
	}

	/**
	 * Get model via GET method, it will check it for array and decode if model
	 * is simply serialized string
	 * @param string $model - Model's name from GET/POST arrays
	 * @param string $method - Receive method type
	 * @param string $scenario - Name of scenario
	 * @return FormModel|Array - Model with attributes or array with founded forms
	 * @throws ErrorException
	 */
	public function getFormModel($model = "model", $method = "post", $scenario = "default") {
		$form = $this->$method($model);
		if (!is_array($form)) {
			return $this->getUrlForm($form, true, $scenario);
		}
		$array = [];
		foreach ($form as $f) {
			$array[] = $this->getUrlForm($f, false, $scenario);
		}
		if (count($this->errors) > 0) {
			$this->postValidationErrors();
		}
		return $array;
	}

	/**
	 * That action will catch widget update and returns
	 * new just rendered component. Override that method
	 * to check necessary privileges and invoke super method
	 */
	public function actionWidget() {
		try {
			// Get widget's class component and unique identification number and method
			$class = $this->requireQueryOnce("class");

			if (isset($_GET["model"])) {
				$model = $this->requireQueryOnce("model");
			} else {
				$model = null;
			}
			if (isset($_GET["method"])) {
				$method = $this->requireQueryOnce("method");
			} else {
				$method = "GET";
			}
			if (isset($_GET["form"])) {
				$form = $this->requireQueryOnce("form");
				if (is_string($form)) {
					$form = $this->decode($form);
				}
			} else {
				$form = null;
			}

			if (strtoupper($method) == "POST") {
				foreach ($_GET as $key => $value) {
					$_POST[$key] = $value;
				}
				$parameters = $_POST;
			} else {
				$parameters = $_GET;
			}

			if ($model != null) {
				$parameters += [
					"model" => new $model(null)
				];
			}

			// Create widget, check for LWidget instance and copy parameters
			$widget = $this->createWidget($class, $parameters);

			if (!($widget instanceof Widget)) {
				throw new ErrorException("Can't update widget which don't extends LWidget component");
			}
			if ($form != null && $widget instanceof Form && is_array($form)) {
				foreach ($form as $key => $value) {
					$widget->model->$key = $value;
				}
			}
			$this->leave([
				"id" => isset($widget->id) ? $widget->id : null,
				"component" => $widget->call(),
				"model" => $form
			]);
		} catch (ErrorException $e) {
			$this->exception($e);
		}
	}

	/**
	 * Create new widget (for backward capability)
	 * @param string $class - Name of class to load
	 * @param array $parameters - List with widget parameters
	 * @return \app\components\Widget - Widget component
	 * @throws ErrorException
	 */
	public function createWidget($class, $parameters = []) {
		if (!class_exists($class)) {
			throw new ErrorException("Unresolved widget module or path \"$class\"");
		}
		return new $class($parameters);
	}

	/**
	 * Check for model existence and return it
	 *
	 * @param string $class - Name of model's form class instance, it
	 *    loads loads and validates with [attributes] parameters
	 * @param array|null|string $regexp - Some forms may contains prefixes or postfixes, so
	 *    use that field to cleanup form's class name
	 * @param array|null $attributes - Attributes to validate
	 * @param string $scenario - Model's scenario usage
	 * @return FormModel - An form model instance
	 * @throws \Exception
	 */
	public function requireModel($class, $attributes = null, $scenario = "default", $regexp = null) {
		$name = $class;
		if (!\Yii::$app->request->bodyParams) {
			throw new \Exception("Can't resolve \"{$class}\" form model");
		}
		if (empty($scenario)) {
			$scenario = "default";
		}
		if ($regexp !== null) {
			$class = preg_replace($regexp, "", $class);
		}
		$class = "app\\components\\forms\\".$class;
		/** @var $form FormModel */
		$form = new $class();
		$form->setScenario($scenario);
		$form->load(\Yii::$app->request->bodyParams);
		if (!$form->validate($attributes)) {
			$errors = [];
			foreach ($form->errors as $key => $e) {
				$errors[$name."[$key]"] = $e;
			}
			$this->errors = ArrayHelper::merge($this->errors, $errors);
		}
		return $form;
	}

	/**
	 * Try to get received data via GET method or throw an exception
	 * with error message
	 * @param $name string - Name of parameter to get
	 * @return mixed - Some received stuff
	 * @throws \Exception - If parameter hasn't been declared in _GET array
	 */
	public function requireQuery($name) {
		if (!isset(\Yii::$app->request->queryParams[$name])) {
			throw new \Exception("That action requires query parameter \"$name\"");
		} else {
			return \Yii::$app->request->queryParams[$name];
		}
	}

	public function getQuery($name, $default = null) {
		if (isset(\Yii::$app->request->queryParams[$name])) {
			return \Yii::$app->request->queryParams[$name];
		} else {
			return $default;
		}
	}

	/**
	 * Try to get and unset variable from GET method or throw an exception
	 * @param String $name - Name of parameter in GET array
	 * @return Mixed - Some received value
	 * @throws ErrorException - If parameter hasn't been declared in _GET array
	 */
	public function requireQueryOnce($name) {
		$value = $this->requireQuery($name);
		unset($_GET[$name]);
		return $value;
	}

	public function getQueryOnce($name, $default = null) {
		$value = $this->getQuery($name, $default);
		unset($_POST[$name]);
		return $value;
	}

	/**
	 * Try to get received data via POST method or throw an exception
	 * with error message
	 * @param $name string - Name of parameter to get
	 * @return mixed - Some received stuff
	 * @throws \Exception - If parameter hasn't been declared in _POST array
	 */
	public function requirePost($name) {
		if (!isset(\Yii::$app->request->bodyParams[$name])) {
			throw new \Exception("That action requires body parameter \"$name\"");
		} else {
			return \Yii::$app->request->bodyParams[$name];
		}
	}

	public function getPost($name, $default = null) {
		if (isset(\Yii::$app->request->bodyParams[$name])) {
			return \Yii::$app->request->bodyParams[$name];
		} else {
			return $default;
		}
	}

	/**
	 * Post error message and terminate script evaluation
	 * @param $message String - Message with error
	 */
	public function error($message) {
		$this->leave([
			"message" => $message,
			"status" => false
		]);
	}

	/**
	 * Leave script execution and print server's response
	 * @param $parameters array - Array with parameters to return
	 * @return null - Nothing
	 */
	public function leave(array $parameters) {
		if (!isset($parameters["status"])) {
			$parameters["status"] = true;
		}
		print json_encode($parameters);
		\Yii::$app->end();
		return null;
	}

	/**
	 * Post error message and terminate script evaluation
	 * @param $exception \Exception - Exception
	 * @return null - Nothing
	 * @throws \Exception
	 */
	public function exception(\Exception $exception) {
		$method = $exception->getTrace()[0];
		if (!\Yii::$app->getRequest()->getIsAjax() || true) {
			throw $exception;
		}
		$this->leave([
			"message" => basename($method["file"])."[".$method["line"]."] ".$method["class"]."::".$method["function"]."(): \"".$exception->getMessage()."\"",
			"file" => basename($method["file"]),
			"method" => $method["class"]."::".$method["function"]."()",
			"line" => $method["line"],
			"status" => false
		]);
		return null;
	}

	private $errors = [];
} 