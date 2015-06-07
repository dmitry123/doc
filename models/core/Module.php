<?php

namespace app\models\core;

use app\core\ActiveRecord;

class Module extends ActiveRecord {

	public function configure() {
		return [
			'id' => [
				'label' => 'Идентификатор',
				'type' => 'text',
			],
			'access_id' => [
				'label' => 'Права доступа',
				'type' => 'dropdown',
			],
			'name' => [
				'label' => 'Наименование',
				'type' => 'text',
			],
			'icon' => [
				'label' => 'Иконка',
				'type' => 'text',
			],
			'url' => [
				'label' => 'Главная страница',
				'type' => 'text',
			],
		];
	}

	public function rules() {
		return [
			[ 'id', 'string', 'max' => 20 ],
			[ 'name', 'string', 'max' => 100 ],
			[ 'icon', 'string', 'max' => 50 ],
			[ 'url', 'string', 'max' => 255 ],
		];
	}

	public static function tableName() {
		return 'core.module';
	}
}