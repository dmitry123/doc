<?php

namespace app\assets;

use app\core\AssetBundle;

class PlantationAsset extends AssetBundle {

	public $js = [
		"js/plantation.js"
	];

	public $css = [
		"css/plantation.css"
	];

	public $depends = [
		"app\\assets\\CoreAsset"
	];
}