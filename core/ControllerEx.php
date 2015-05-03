<?php

namespace app\core;

use Exception;

abstract class ControllerEx extends Controller {

	/**
	 * @return ActiveRecord - Instance of active record
	 * 	class for current controller
	 */
	public abstract function getModel();

	/**
	 * @return FormModel - Instance of form model class
	 * 	for current controller's model
	 */
	public abstract function getForm();

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
				throw new Exception("Forms to register mustn't be array");
			}
			if (($table = $this->getModel(null)) == null) {
				throw new Exception("Your controller must override LController::getModel method");
			}
			foreach ($model->attributes as $key => $value) {
				$table->__set($key, $value);
			}
			$table->__unset("id");
			$table->save();
			$this->leave([
				"message" => "Данные успешно сохранены"
			]);
		} catch (Exception $e) {
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
			$this->getModel(null)->deleteByPk($this->requirePost("id"), "id = :id", [
				":id" => $this->requirePost("id")
			]);
			$this->leave([
				"message" => "Элемент был успешно удален"
			]);
		} catch (Exception $e) {
			$this->exception($e);
		}
	}
}