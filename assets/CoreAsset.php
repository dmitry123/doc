<?php

namespace app\assets;

use yii\web\AssetBundle;

class CoreAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		"css/site.css",
		"css/multiple.css"
	];

	public $js = [
		"js/core.js",
		"js/message.js",
		"js/form.js",
		"js/multiple.js"
	];

	public $depends = [
		"yii\\web\\YiiAsset",
		"yii\\bootstrap\\BootstrapAsset",
	];
}