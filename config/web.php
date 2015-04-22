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
			"icon" => "glyphicon glyphicon-list-alt",
			"image" => "img/icons/matrix.png",
			"roles" => [
				"director",
				"manager",
				"student",
				"teacher",
				"super",
			]
		],
		"schedule" => [
			"class" => "app\\modules\\schedule\\ScheduleModule",
			"name" => "Расписание",
			"icon" => "glyphicon glyphicon-calendar",
			"image" => "img/icons/schedule.png",
			"roles" => [
				"director",
				"manager",
				"student",
				"teacher",
				"super",
			]
		],
		"doc" => [
			"class" => "app\\modules\\doc\\DocModule",
			"name" => "Документы",
			"icon" => "glyphicon glyphicon-duplicate",
			"image" => "img/icons/doc.png",
			"roles" => [
				"director",
				"manager",
				"teacher",
				"super",
			],
			"url" => "doc/file/view"
		],
		"chat" => [
			"class" => "app\\modules\\chat\\ChatModule",
			"name" => "Чат",
			"icon" => "glyphicon glyphicon-send",
			"image" => "img/icons/chat.png",
			"roles" => [
				"admin",
				"director",
				"manager",
				"teacher",
				"super",
			]
		],
		"plantation" => [
			"class" => "app\\modules\\admin\\PlantationModule",
			"name" => "Внедрение",
			"icon" => "glyphicon glyphicon-globe",
			"roles" => [
				"admin",
				"super",
			]
		],
		"admin" => [
			"class" => "app\\modules\\admin\\AdminModule",
			"name" => "Управление",
			"icon" => "glyphicon glyphicon-cog",
			"image" => "img/icons/admin.png",
			"roles" => [
				"admin",
				"super",
			],
			"url" => "admin/master/view"
		],
	],
    'params' => $params,
];

return $config;
