<?php

namespace app\modules\doc\grids;

use app\core\GridProviderWrite;
use app\models\doc\FileExt;

class FileExtGridProvider extends GridProviderWrite {

	public $columns = [
		'id' => '#',
		'ext' => 'Расширение',
		'file_type_id' => 'Тип файла',
	];

	public $sort = [
		'attributes' => [
			'id', 'ext', 'file_type_id',
		],
		'orderBy' => [
			'id' => SORT_DESC,
		]
	];

	public $search = [
		'attributes' => [
			'id', 'ext', 'file_type_id',
		]
	];

	public function getQuery() {
		return FileExt::find();
	}
}