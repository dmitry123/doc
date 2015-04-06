<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

\yii\base\Event::on(\yii\web\View::className(), \yii\web\View::EVENT_END_BODY, function($event) {
	foreach ($event->sender->assetBundles as $name => $bundle) {
		if (!$bundle instanceof \app\core\AssetBundle) {
			continue;
		}
		foreach ($bundle->modals as $modal) {
			print \app\widgets\Modal::widget($modal);
		}
	}
});

(new yii\web\Application($config))->run();