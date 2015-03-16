<?php

namespace app\core;

abstract class TableProvider extends ActiveRecord {

	/**
	 * Override that method to return form model for
	 * current class with configuration, form model
	 * must be an instance of app\core\FormModel and
	 * implements [config] method
	 * @see FormModel::config
	 * @return FormModel - Instance of form model
	 */
	public abstract function getFormModel();

	/**
	 * Get count of rows for current provider
	 * @return int - Count of rows
	 */
	public function getCount() {
		$r = $this->find()->select("count(1) as count")
			->from($this->tableName())
			->all();
		if (!$r) {
			return 0;
		}
		return $r["column"];
	}

	/**
	 * Get array with table active records for current provider
	 * @return \yii\db\ActiveRecord[] - Array with records
	 */
	public function getRows() {
		$rows = $this->find()->select("*")
			->from($this->tableName())
			->all();
		return $rows;
	}
}