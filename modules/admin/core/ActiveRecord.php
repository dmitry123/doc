<?php

namespace app\modules\admin\core;

use app\core\TableProvider;

abstract class ActiveRecord extends \app\core\ActiveRecord {

	/**
	 * That method will create table provider for
	 * current table model with it's form
	 */
	public function search() {
		return new TableProvider($this);
	}
}