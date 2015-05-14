<?php

namespace app\assets;

use app\components\AssetBundle;

class BlockAsset extends AssetBundle {

	public $css = [
		"css/block.css"
	];

	public $js = [
		"js/block.js"
	];

	public $depends = [
		"app\\assets\\CoreAsset"
	];
}