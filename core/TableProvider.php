<?php

namespace app\core;

use yii\db\Query;

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
		$r = (new Query())
			->select("count(1) as count")
			->from($this->getTableName())
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
		$rows = (new Query())
			->select("*")
			->from($this->getTableName())
			->all();
		return $rows;
	}
}