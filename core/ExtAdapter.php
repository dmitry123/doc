<?php

namespace app\core;

class ExtAdapter extends Ext {

	/**
	 * @var string name of action's identifier
	 * 	to invoke
	 */
	public $action = null;

	/**
	 * That action adapt parent's invoke action to
	 * it's action
	 *
	 * @param $action string with custom action name
	 * @return mixed value from parent's invoke
	 */
	public function invoke($action = null) {
		return parent::invoke($action !== null ? $action : $this->action);
	}
}