<?php

namespace app\assets;

use yii\web\AssetBundle;

class CoreAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		"css/multiple.css",
		"css/message.css",
		"css/panel.css",
		"css/table.css"
	];

	public $js = [
		"js/core.js",
		"js/message.js",
		"js/form.js",
		"js/multiple.js",
		"js/loading.js",
		"js/table.js",
		"js/panel.js"
	];

	public $depends = [
		"yii\\web\\YiiAsset",
		"yii\\bootstrap\\BootstrapAsset",
	];
}