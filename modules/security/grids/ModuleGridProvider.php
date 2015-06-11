<?php

namespace app\modules\security\grids;

use app\core\GridProviderWrite;
use app\models\core\Module;

class ModuleGridProvider extends GridProviderWrite {

	public $columns = [
		'id' => '#',
		'access_id' => 'Доступ',
		'name' => 'Название',
		'icon' => 'Иконка',
		'url' => ' Главная',
	];

	public $sort = [
		'attributes' => [
			'id', 'access_id', 'name', 'icon', 'url',
		],
		'orderBy' => [
			'name' => SORT_ASC,
		]
	];

	public $search = [
		'attributes' => [
			'id', 'access_id', 'name', 'icon', 'url',
		]
	];

	public function getQuery() {
		return Module::find();
	}
}