<?php

namespace app\assets;

use app\components\AssetBundle;

class CoreAsset extends AssetBundle {

	public $css = [
		"css/multiple.css",
		"css/message.css",
		"css/panel.css",
		"css/table.css",
		"css/glyphicons-filetypes.css",
		"css/glyphicons-halflings.css",
		"css/glyphicons-social.css",
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
//		"js/object.js"
	];

	public $depends = [
		"yii\\web\\YiiAsset",
		"yii\\bootstrap\\BootstrapAsset",
	];
}