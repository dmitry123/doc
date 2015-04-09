<?php

namespace app\assets;

use app\core\AssetBundle;

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