<?php

namespace app\widgets;

use app\core\ClassHelper;
use app\core\FormModel;
use app\core\Widget;
use yii\base\Exception;

class AutoForm extends Widget {

	public $types = [
		"text" => "textInput",
		"password" => "passwordInput",
		"email" => "input",
		"hidden" => "hiddenInput",
		"file" => "fileInput",
		"textarea" => "textarea",
		"radio" => "radio",
		"checkbox" => 'checkbox',
		"dropdown" => "dropDownList",
		"list" => "listBox",
		"checkboxList" => "checkboxList",
		"radioList" => "radioList"
	];

	/**
	 * @var string form's identification value elsewhere
	 * 	it generates automatically
	 */
	public $id = null;

	/**
	 * @var FormModel|string instance of form model class
	 * 	or name of it's class
	 */
	public $model = null;

	/**
	 * @var string relative url for controller's action
	 * 	to execute form
	 */
	public $url = null;

	/**
	 * @var array with attributes names that should be
	 * 	excepted from auto rendering
	 */
	public $except = [];

	/**
	 * Run widget
	 */
	public function run() {
		if (is_string($this->model)) {
			$this->model = new $this->model();
		}
		if (!$this->model instanceof FormModel) {
			throw new Exception("Model must be an instance of [FormModel] class");
		}
		if ($this->url !== null) {
			$url = \Yii::$app->getUrlManager()->createUrl($this->url);
		} else {
			$url = null;
		}
		$form = ActiveForm::begin([
			"action" => $url,
			"id" => $this->id
		]);
		foreach (ClassHelper::getProperties($this->model->className()) as $key) {
			if (in_array($key, $this->except)) {
				continue;
			}
			$config = $this->model->getActiveRecord()->getConfig($key);
			$type = $config["type"];
			if (isset($this->types[$type])) {
				if ($this->types[$type] == "input") {
					print $form->field($this->model, $key)->input($this->types[$type]);
				} else {
					print $form->field($this->model, $key)->{$this->types[$type]}();
				}
			} else if (class_exists($type)) {
				print $form->field($this->model, $key)->widget($type, $config);
			} else {
				throw new Exception("Unresolved attribute type");
			}
		}
		$form->end();
	}
}