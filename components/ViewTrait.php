<?php

namespace app\components;

trait ViewTrait {

	public function beforeSave($insert) {
		return $insert ? false : false;
	}

	public function beforeDelete() {
		return false;
	}
}