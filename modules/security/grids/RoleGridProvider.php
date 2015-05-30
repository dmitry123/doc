<?php

namespace app\modules\security\grids;

use app\core\GridProvider;
use yii\db\ActiveQuery;

class RoleGridProvider extends GridProvider {

	/**
	 * Override that method to return instance
	 * of ActiveQuery class
	 *
	 * @return ActiveQuery
	 */
	public function getQuery() {
		return [
		];
	}
}