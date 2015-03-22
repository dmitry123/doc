<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
		"urlManager" => [
			"enablePrettyUrl" => true,
			"showScriptName" => false
		],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [ 'error', 'warning' ],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
	'modules' => [
		"matrix" => [
			"class" => "app\\modules\\matrix\\MatrixModule",
			"name" => "Матрица",
			"icon" => "glyphicon glyphicon-list-alt"
		],
		"doc" => [
			"class" => "app\\modules\\doc\\DocModule",
			"name" => "Документы",
			"icon" => "glyphicon glyphicon-duplicate"
		],
		"chat" => [
			"class" => "app\\modules\\chat\\ChatModule",
			"name" => "Чат",
			"icon" => "glyphicon glyphicon-send"
		],
		"distance" => [
			"class" => "app\\modules\\chat\\DistanceModule",
			"name" => "Обучение",
			"icon" => "glyphicon glyphicon-education"
		],
		"admin" => [
			"class" => "app\\modules\\admin\\AdminModule",
			"name" => "Управление",
			"icon" => "glyphicon glyphicon-cog"
		],
	],
    'params' => $params,
];

//if (YII_ENV_DEV) {
//    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = 'yii\debug\Module';
//
//    $config['bootstrap'][] = 'gii';
//    $config['modules']['gii'] = 'yii\gii\Module';
//}

return $config;
