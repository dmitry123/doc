<?php

namespace app\modules\security\grids;

use app\core\GridProviderWrite;
use app\models\core\Privilege;

class PrivilegeGridProvider extends GridProviderWrite {

	public $columns = [
		'id' => '#',
		'name' => 'Название',
		'description' => 'Описание',
	];

	public $sort = [
		'attributes' => [
			'id', 'name', 'description',
		],
		'orderBy' => [
			'name' => SORT_ASC,
		]
	];

	public $search = [
		'attributes' => [
			'id', 'name', 'description',
		]
	];

	public function getQuery() {
		return Privilege::find();
	}
}