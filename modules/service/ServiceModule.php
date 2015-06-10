<?php

namespace app\modules\service;

use app\core\Module;
use app\modules\service\assets\ServiceAsset;

class ServiceModule extends Module {

	public function init() {
		ServiceAsset::register(\Yii::$app->getView());
		parent::init();
	}
}