<?php

namespace app\modules\security\grids;

use app\core\GridProviderWrite;
use app\models\core\Group;

class GroupGridProvider extends GridProviderWrite {

	public $columns = [
		'id' => '#',
		'parent_id' => 'Родитель',
		'name' => 'Название',
	];

	public $sort = [
		'attributes' => [
			'id', 'name', 'parent_id',
		],
		'orderBy' => [
			'name' => SORT_ASC,
		]
	];

	public $search = [
		'attributes' => [
			'id', 'name', 'parent_id',
		]
	];

	public function getQuery() {
		return Group::find();
	}
}