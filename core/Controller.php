<?php

namespace app\core;

use app\widgets\Form;
use yii\base\ErrorException;
use yii\base\Model;
use yii\base\Widget;
use yii\web\Session;

abstract class Controller extends \yii\base\Controller {

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model Model - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public abstract function getModel($model);

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
				$this->leave([
					"message" => "Произошли ошибки во время валидации формы",
					"errors" => $form->getErrors(),
					"status" => false
				]);
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
	public function postValidationErrors($model) {
		$this->leave([
			"message" => "Произошли ошибки во время валидации формы",
			"errors" => $model->getErrors(),
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
	public function getFormModel($model = "model", $method = "get", $scenario = null) {
		$form = $this->$method($model);
		if (!is_array($form)) {
			return $this->getUrlForm($form, true, $scenario);
		}
		$array = [];
		foreach ($form as $f) {
			$array[] = $this->getUrlForm($f, false, $scenario);
		}
		if (count($this->errors) > 0) {
			$this->leave([
				"message" => "Произошли ошибки во время валидации формы",
				"errors" => $this->errors,
				"status" => false
			]);
		}
		return $array;
	}

	/**
	 * That action will catch widget update and returns
	 * new just rendered component. Override that method
	 * to check necessary privileges and invoke super method
	 */
	public function actionGetWidget() {
		try {
			// Get widget's class component and unique identification number and method
			$class = $this->getAndUnset("class");

			if (isset($_GET["model"])) {
				$model = $this->getAndUnset("model");
			} else {
				$model = null;
			}
			if (isset($_GET["method"])) {
				$method = $this->getAndUnset("method");
			} else {
				$method = "GET";
			}
			if (isset($_GET["form"])) {
				$form = $this->getAndUnset("form");
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
	 * @return \app\core\Widget - Widget component
	 * @throws ErrorException
	 */
	public function createWidget($class, $parameters = []) {
		if (strpos($class, "/") != 1) {
			$class = "/app/";
			foreach ($this->getModules() as $module) {
				$class .= get_class($module);
			}
		}
		if (!class_exists($class)) {
			throw new ErrorException("Unresolved widget module or path \"$class\"");
		}
		$widget = new $class();
		foreach ($parameters as $key => $value) {
			$widget->$key = $value;
		}
		return $widget;
	}

	/**
	 * Register some form's values in database, it will automatically
	 * fetch model from $_POST["model"], decode it, build it's LFormModel
	 * object and save into database. But you must override
	 * LController::getModel and return instance of controller's model else
	 * it will throw an exception
	 *
	 * @in (POST):
	 *  + model - String with serialized client form via $("form").serialize(), if you're
	 * 		using LModal or LPanel widgets that it will automatically find button with
	 * 		submit type and send ajax request
	 * @out (JSON):
	 *  + message - Message with status
	 *  + status - True if everything ok
	 *
	 * @see LController::getModel
	 * @see LModal
	 * @see LPanel
	 */
	protected function actionRegister() {
		try {
			$model = $this->getFormModel("model", "post", "register");
			if (is_array($model)) {
				throw new ErrorException("Forms to register mustn't be array");
			}
			if (($table = $this->getModel()) == null) {
				throw new ErrorException("Your controller must override LController::getModel method");
			}
			foreach ($model->attributes as $key => $value) {
				$table->__set($key, $value);
			}
			$table->__unset("id");
			$table->save();
			$this->leave([
				"message" => "Данные успешно сохранены"
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Override that method to remove element from model, by default
	 * it will try to find controller's model and remove it
	 *
	 * @in (POST):
	 *  + id - Element's identification number
	 * @out (JSON):
	 *  + message - Response message
	 *  + status - True if everything ok
	 */
	protected function actionDelete() {
		try {
			$this->getModel()->deleteByPk($this->post("id"), "id = :id", [
				":id" => $this->post("id")
			]);
			$this->leave([
				"message" => "Элемент был успешно удален"
			]);
		} catch (ErrorException $e) {
			$this->exception($e);
		}
	}

	/**
	 * Get session instance with current session
	 * @return Session - Yii http session
	 */
	public function getSession() {
		if ($this->session == null) {
			$this->session = new Session();
		}
		return $this->session;
	}

	/**
	 * Try to get received data via GET method or throw an exception
	 * with error message
	 * @param $name string - Name of parameter to get
	 * @return mixed - Some received stuff
	 * @throws ErrorException - If parameter hasn't been declared in _GET array
	 */
	public function get($name) {
		if (!isset($_GET[$name])) {
			throw new ErrorException("GET.$name");
		}
		return $_GET[$name];
	}

	/**
	 * Try to get and unset variable from GET method or throw an exception
	 * @param String $name - Name of parameter in GET array
	 * @return Mixed - Some received value
	 * @throws ErrorException - If parameter hasn't been declared in _GET array
	 */
	public function getAndUnset($name) {
		$value = $this->get($name);
		unset($_GET[$name]);
		return $value;
	}

	/**
	 * Try to get received data via POST method or throw an exception
	 * with error message
	 * @param $name string - Name of parameter to get
	 * @return mixed - Some received stuff
	 * @throws ErrorException - If parameter hasn't been declared in _POST array
	 */
	public function post($name) {
		if (!isset($_POST[$name])) {
			throw new ErrorException("POST.$name");
		}
		return $_POST[$name];
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
	 */
	public function leave(array $parameters) {
		if (!isset($parameters["status"])) {
			$parameters["status"] = true;
		}
		die(json_encode($parameters));
	}

	/**
	 * Post error message and terminate script evaluation
	 * @param $exception \Exception - Exception
	 * @throws \Exception
	 */
	public function exception(\Exception $exception) {
		$method = $exception->getTrace()[0];
		if (\Yii::$app->getRequest()->getIsAjax() && false) {
			$this->leave([
				"message" => basename($method["file"])."[".$method["line"]."] ".$method["class"]."::".$method["function"]."(): \"".$exception->getMessage()."\"",
				"file" => basename($method["file"]),
				"method" => $method["class"]."::".$method["function"]."()",
				"line" => $method["line"],
				"status" => false,
				"trace" => $exception->getTrace()
			]);
		} else {
			throw $exception;
		}
	}

	private $session = null;
	private $errors = [];
} 