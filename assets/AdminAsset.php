<?php

namespace app\assets;

use app\core\AssetBundle;

class AdminAsset extends AssetBundle {

	public $css = [
		"css/admin.css"
	];

	public $js = [
		"js/admin.js"
	];

	public $depends = [
		"app\\assets\\SiteAsset"
	];
}