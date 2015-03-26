<?php

namespace app\assets;

use yii\web\AssetBundle;

class LogoAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		"css/logo.css"
	];

	public $js = [
	];

	public $depends = [
	];
}