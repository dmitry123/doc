<?php

namespace app\modules\admin\core;

use app\components\TableProvider;

abstract class ActiveRecord extends \app\components\ActiveRecord {

	/**
	 * That method will create table provider for
	 * current table model with it's form
	 */
	public function search() {
		return new TableProvider($this);
	}
}