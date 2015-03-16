<?php

namespace app\assets;

use yii\web\AssetBundle;

class SiteAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
		"css/sidenav.css",
		"css/fileinput.css"
    ];

    public $js = [
		"js/sidenav.js",
		"js/fileinput.js",
		"js/site.js",
    ];

	public $depends = [
        "app\\assets\\CoreAsset"
    ];
}
