<?php

namespace app\modules\service\assets;

use app\core\AssetBundle;

class ServiceAsset extends AssetBundle {

	public $css = [
		'css/admin.css'
	];

	public $js = [
		'js/service.js'
	];

	public $depends = [
		'app\assets\SiteAsset'
	];
}