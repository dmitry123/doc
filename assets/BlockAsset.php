<?php

namespace app\assets;

use yii\web\AssetBundle;

class BlockAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		"css/block.css",
	];

	public $js = [
		"js/block.js"
	];

	public $depends = [
		"app\\assets\\CoreAsset"
	];
}