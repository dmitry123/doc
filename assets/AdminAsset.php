<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
	];

	public $js = [
	];

	public $depends = [
		"app\\assets\\CoreAsset"
	];
}