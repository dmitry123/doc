<?php

namespace app\core;

class ActiveDataProvider extends \yii\data\ActiveDataProvider {

	/**
	 * @var array with name of columns identifications
	 * 	which should be displayed
	 */
	public $columns = null;

	/**
	 * @var string name of model's primary key which
	 * 	copies to every <tr> element
	 */
	public $primaryKey = "id";

	/**
	 * @var array with list of available page
	 * 	limits
	 */
	public $availableLimits = [
		10, 25, 50, 75
	];
}