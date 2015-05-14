<?php

namespace app\assets;

use app\components\AssetBundle;

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