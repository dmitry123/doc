<?php

namespace app\assets;

use app\core\AssetBundle;

class DocAsset extends AssetBundle {

	public $css = [
		"css/doc.css"
	];

	public $js = [
		"js/doc.js"
	];

	public $depends = [
		"app\\assets\\SiteAsset"
	];
}