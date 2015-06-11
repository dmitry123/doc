<?php

namespace app\modules\doc\grids;

use app\core\GridProviderWrite;
use app\models\doc\FileType;

class FileTypeGridProvider extends GridProviderWrite {

	public $columns = [
		'id' => [ 'label' => '#', 'width' => '50px'],
		'name' => 'Название',
	];

	public $sort = [
		'attributes' => [
			'id', 'name',
		],
		'orderBy' => [
			'id' => SORT_DESC,
		]
	];

	public $search = [
		'attributes' => [
			'id', 'name',
		]
	];

	public function getQuery() {
		return FileType::find();
	}
}