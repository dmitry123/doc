<?php return [
	"matrix" => [
		"class" => "app\\modules\\matrix\\MatrixModule",
		"name" => "Матрица",
		"icon" => "fa fa-group",
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
		"icon" => "fa fa-calendar",
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
		"icon" => "fa fa-file-text",
		"roles" => [
			"director",
			"manager",
			"teacher",
			"super",
		],
		"url" => "doc/file/view"
	],
//	"chat" => [
//		"class" => "app\\modules\\chat\\ChatModule",
//		"name" => "Чат",
//		"icon" => "glyphicon glyphicon-send",
//		"roles" => [
//			"admin",
//			"director",
//			"manager",
//			"teacher",
//			"super",
//		]
//	],
	"plantation" => [
		"class" => "app\\modules\\plantation\\PlantationModule",
		"name" => "Внедрение",
		"icon" => "fa fa-user-secret",
		"roles" => [
			"admin",
			"super",
		],
		"url" => "plantation/master/view"
	],
	"security" => [
		"class" => "app\\modules\\security\\SecurityModule",
		"name" => "Безопасность",
		"icon" => "fa fa-lock",
		"roles" => [
			"admin",
			"super",
		],
		"url" => "security/role/list"
	],
	"admin" => [
		"class" => "app\\modules\\admin\\AdminModule",
		"name" => "Управление",
		"icon" => "fa fa-wrench",
		"roles" => [
			"admin",
			"super",
		],
		"url" => "admin/master/view"
	],
];