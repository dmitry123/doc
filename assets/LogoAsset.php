<?php

namespace app\assets;

use app\components\AssetBundle;

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