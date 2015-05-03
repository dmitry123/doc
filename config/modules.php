<?php return [
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
		"class" => "app\\modules\\plantation\\PlantationModule",
		"name" => "Внедрение",
		"icon" => "glyphicon glyphicon-globe",
		"roles" => [
			"admin",
			"super",
		],
		"url" => "plantation/master/view"
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
	"security" => [
		"class" => "app\\modules\\security\\SecurityModule",
		"name" => "Безопасность",
		"icon" => "glyphicon glyphicon-lock",
		"roles" => [
			"admin",
			"super",
		]
	]
];