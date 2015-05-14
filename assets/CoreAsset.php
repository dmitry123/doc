<?php

namespace app\assets;

use app\core\AssetBundle;

class CoreAsset extends AssetBundle {

	public $css = [
		"css/multiple.css",
		"css/message.css",
		"css/panel.css",
		"css/table.css",
		"css/font-awesome.css"
	];

	public $js = [
		"js/core.js",
		"js/message.js",
		"js/form.js",
		"js/multiple.js",
		"js/loading.js",
		"js/table.js",
		"js/panel.js",
        "js/context.js"
//		"js/object.js"
	];

	public $depends = [
		"yii\\web\\YiiAsset",
		"yii\\bootstrap\\BootstrapAsset",
	];
}