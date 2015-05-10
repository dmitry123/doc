<?php

namespace app\core;

class Sort extends \yii\data\Sort {

	/**
	 * @var array with order parameters, where key is column
	 *  name and value is SORT_DESC or SORT_ASC
	 */
	public $orderBy = [
		"id" => SORT_ASC
	];

	/**
	 * Get array with orders from [@see orderBy] field
	 * @param $recalculate bool ignored (method override)
	 * @return array with order parameters
	 */
	public function getOrders($recalculate = false) {
		if (!$this->orderBy) {
			return [];
		}
		$result = [];
		foreach ($this->orderBy as $key => $value) {
			$result[] = ($key ." ". ($value == SORT_DESC ? "desc" : ""));
		}
		return implode(",", $result);
	}
}