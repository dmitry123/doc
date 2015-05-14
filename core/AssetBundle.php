<?php

namespace app\core;

class AssetBundle extends \yii\web\AssetBundle {

	/**
	 * @var string the Web-accessible directory that contains the asset files in this bundle.
	 *
	 * If [[sourcePath]] is set, this property will be *overwritten* by [[AssetManager]]
	 * when it publishes the asset files from [[sourcePath]].
	 *
	 * You can use either a directory or an alias of the directory.
	 */
	public $basePath = '@webroot';

	/**
	 * @var string the base URL for the relative asset files listed in [[js]] and [[css]].
	 *
	 * If [[sourcePath]] is set, this property will be *overwritten* by [[AssetManager]]
	 * when it publishes the asset files from [[sourcePath]].
	 *
	 * You can use either a URL or an alias of the URL.
	 */
	public $baseUrl = '@web';
}