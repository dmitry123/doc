<?php

namespace app\core;

use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\base\Object;

class TableProviderAdapter extends TableProvider {

	/**
	 * @var ActiveRecord - Active record instance for
	 * 	table provider adapter
	 * @see TableProvider
	 */
	public $model;

	/**
	 * @var FormModel - Form model instance for
	 * 	table provider adapter
	 * @see TableProvider::getFormModel
	 */
	public $form;

	/**
	 * Create table provider with database model and it's form model instances
	 * @param ActiveRecord $model - Active record instance
	 * @param FormModel $form - Form's model instance with configuration
	 * @param array $config - Table provider configuration
	 *  + joins - array with tables to join
	 *  + keys - array with fields names to display
	 *  + order - string with default order field
	 * @return TableProviderAdapter - Table provider instance
	 * @throws ErrorException
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function createProvider($model, $form, $config = []) {
		if (!$model instanceof ActiveRecord) {
			throw new ErrorException("Model must be an instance of ActiveRecord class, found \"" . get_class($model) . "\"");
		}
		if (!$form instanceof FormModel) {
			throw new ErrorException("Form must be an instance of FormModel class, found \"" . get_class($model) . "\"");
		}
		return \Yii::createObject($config + [
				"class" => TableProviderAdapter::className(),
				"form" => $form,
				"model" => $model
			]);
	}

	/**
	 * Get count of rows for current provider
	 * @return int - Count of rows
	 */
	public function getCount() {
		$query = $this->model->find()->select("count(1) as count")
			->from($this->getTableName());
		return ($r = $this->prepareQuery($query)->one())
			? $r["column"] : 0;
	}

	/**
	 * Get array with table active records for current provider
	 * @return \yii\db\ActiveRecord[] - Array with records
	 */
	public function getRows() {
		$query = $this->model->find()->select(implode(",", $this->keys))
			->from($this->getTableName());
		return $this->prepareQuery($query)->all();
	}

	/**
	 * Helper method to get table's name for dynamic context
	 * @return string - Name of table
	 */
	public function getTableName() {
		return $this->model->getTableName();
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
		return $this->form;
	}
}