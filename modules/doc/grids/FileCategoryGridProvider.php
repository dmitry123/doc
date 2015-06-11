<?php

namespace app\modules\doc\grids;

use app\core\GridProviderWrite;
use app\models\doc\FileCategory;

class FileCategoryGridProvider extends GridProviderWrite {

	public $columns = [
		'id' => [ 'label' => '#', 'width' => '50px'],
		'name' => 'Название',
		'parent_id' => 'Родитель',
	];

	public $sort = [
		'attributes' => [
			'id', 'name', 'parent_id',
		],
		'orderBy' => [
			'id' => SORT_DESC,
		]
	];

	public $search = [
		'attributes' => [
			'id', 'name', 'parent_id',
		]
	];

	public function getQuery() {
		return FileCategory::find();
	}
}