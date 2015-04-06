<?php

return [
	"fileUploadDirectory" => "/../uploads/files",
	"defaultRoles" => [
		"super" => [
			"name" => "Супервайзер",
			"description" => "Имеет полный доступ к системе"
		],
		"admin" => [
			"name" => "Администратор",
			"description" => "Может администрировать систему"
		]
	],
	"defaultUsers" => [
		"system" => [
			'email' => 'dmitry123@inbox.ru',
			'password' => 'super123',
			'surname' => 'Савонин',
			'name' => 'Дмитрий',
			'patronymic' => 'Александрович',
			'phone' => '+79160531323',
			'role' => 'super'
		],
		"admin" => [
			'email' => 'nwtsoas@gmail.com',
			'password' => 'admin123',
			'surname' => 'Савонин',
			'name' => 'Дмитрий',
			'patronymic' => 'Александрович',
			'phone' => '+79160531323',
			'role' => 'admin'
		]
	],
];
