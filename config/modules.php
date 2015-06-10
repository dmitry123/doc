<?php

return [
	'matrix' => [
		'class' => 'app\modules\matrix\MatrixModule',
		'name' => 'Матрица',
		'icon' => 'fa fa-group',
		'roles' => [
			'director',
			'manager',
			'student',
			'teacher',
			'super',
		]
	],
	'schedule' => [
		'class' => 'app\modules\schedule\ScheduleModule',
		'name' => 'Расписание',
		'icon' => 'fa fa-calendar',
		'roles' => [
			'director',
			'manager',
			'student',
			'teacher',
			'super',
		]
	],
	'doc' => [
		'class' => 'app\modules\doc\DocModule',
		'name' => 'Документы',
		'icon' => 'fa fa-file-text',
		'roles' => [
			'director',
			'manager',
			'teacher',
			'super',
		],
		'url' => 'doc/file/view'
	],
	'security' => [
		'class' => 'app\modules\security\SecurityModule',
		'name' => 'Безопасность',
		'icon' => 'fa fa-user-secret',
		'roles' => [
			'admin',
			'super',
		],
		'url' => 'security/role/list'
	],
	'service' => [
		'class' => 'app\modules\service\ServiceModule',
		'name' => 'Управление',
		'icon' => 'fa fa-wrench',
		'roles' => [
			'admin',
			'super',
		],
		'url' => 'service/setting'
	],
];