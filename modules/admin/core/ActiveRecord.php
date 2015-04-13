<?php

namespace app\modules\admin\core;

use app\core\FormModel;
use app\core\TableProvider;

abstract class ActiveRecord extends \app\core\ActiveRecord {

	/**
	 * Override that method to return form model, that
	 * associated with current table model
	 *
	 * @return FormModel - Basic core form model instance
	 */
	public abstract function getForm();

	/**
	 * That method will create table provider for
	 * current table model with it's form
	 */
	public function search() {
		return new TableProvider($this);
	}
}