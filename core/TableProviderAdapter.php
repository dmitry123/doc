<?php

namespace app\core;

use yii\base\ErrorException;

class TableProviderAdapter extends TableProvider {

	/**
	 * Create table provider with database model and it's form model instances
	 * @param ActiveRecord $model - Active record instance
	 * @param FormModel $form - Form's model instance with configuration
	 * @return TableProviderAdapter - Table provider instance
	 * @throws ErrorException
	 */
	public static function createProvider($model, $form) {
		if (!$model instanceof ActiveRecord) {
			throw new ErrorException("Model must be an instance of ActiveRecord class, found \"" . get_class($model) . "\"");
		}
		if (!$form instanceof FormModel) {
			throw new ErrorException("Form must be an instance of FormModel class, found \"" . get_class($model) . "\"");
		}
		$provider = new TableProviderAdapter();
		$provider->_model = $model;
		$provider->_form = $form;
		return $provider;
	}

	/**
	 * Helper method to get table's name for dynamic context
	 * @return string - Name of table
	 */
	public function getTableName() {
		return $this->_model->tableName();
	}

	/**
	 * Override that method to return form model for
	 * current class with configuration, form model
	 * must be an instance of app\core\FormModel and
	 * implements [config] method
	 * @see FormModel::config
	 * @return FormModel - Instance of form model
	 */
	public function getFormModel() {
		return $this->_form;
	}

	/**
	 * @var ActiveRecord
	 */
	private $_model;

	/**
	 * @var FormModel
	 */
	private $_form;
}