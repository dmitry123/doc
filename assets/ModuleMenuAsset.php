<?php

namespace app\assets;

use yii\web\AssetBundle;

class ModuleMenuAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		"css/module-menu.css"
	];

	public $js = [
		"js/module-menu.js"
	];

	public $depends = [
		"app\\assets\\CoreAsset"
	];
}