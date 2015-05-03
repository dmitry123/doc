<?php

namespace app\assets;

use app\core\AssetBundle;

class LogoAsset extends AssetBundle {

	public $css = [
		"css/logo.css"
	];

	public $js = [
	];

	public $depends = [
		"app\\assets\\CoreAsset"
	];
}