<?php

namespace app\core;

use yii\db\Query;

abstract class TableProvider extends ActiveRecord {

	/**
	 * Override that field to set array with
	 * tables to join for current query
	 *
	 *  + table - name of table to join
	 *  + [type] - join type (default 'INNER JOIN')
	 *  + on - condition on join
	 *
	 * @var array - Table joins
	 */
	public $joins = [];

	/**
	 * Override that field to set array with
	 * fields that should be displayed
	 *
	 * @var array - Fields names to display
	 */
	public $keys = [ "*" ];

	/**
	 * Override that field to set order type, default
	 * order type is row's identification number. Set it
	 * to false or null to disable order
	 *
	 * @var string - Default order
	 */
	public $order = "id";

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
	 * @param Query $query
	 * @return Query - Query itself
	 */
	public function prepareQuery($query) {
		foreach ($this->joins as $join) {
			if (isset($join["type"])) {
				$type = $join["type"];
			} else {
				$type = "INNER JOIN";
			}
			$query->join($type, $join["table"], $join["on"]);
		}
		if (!empty($this->order)) {
			$query->orderBy($this->order);
		}
		return $query;
	}

	/**
	 * Get count of rows for current provider
	 * @return int - Count of rows
	 */
	public function getCount() {
		$query = $this->find()->select("count(1) as count")
			->from($this->getTableName());
		return ($r = $this->prepareQuery($query)->one())
			? $r["column"] : 0;
	}

	/**
	 * Get array with table active records for current provider
	 * @return \yii\db\ActiveRecord[] - Array with records
	 */
	public function getRows() {
		$query = $this->find()->select(implode(",", $this->keys))
			->from($this->getTableName());
		return $this->prepareQuery($query)->all();
	}
}