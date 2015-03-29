<?php

namespace app\assets;

use yii\web\AssetBundle;

class DocAsset extends AssetBundle {

	public $basePath = '@webroot';
	public $baseUrl = '@web';

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