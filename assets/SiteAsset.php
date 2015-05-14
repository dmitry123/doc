<?php

namespace app\assets;

use app\components\AssetBundle;

class SiteAsset extends AssetBundle {

    public $css = [
		"css/site.css",
		"css/module-menu.css",
		"css/fileinput.css",
    ];

    public $js = [
		"js/fileinput.js",
		"js/module-menu.js",
		"js/site.js",
    ];

	public $depends = [
        "app\\assets\\CoreAsset"
    ];
}
