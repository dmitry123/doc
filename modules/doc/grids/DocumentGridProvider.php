<?php

namespace app\modules\doc\grids;

use app\core\GridProvider;
use app\models\doc\File;

class DocumentGridProvider extends GridProvider {

	/**
	 * @var string name of file type, that should be loaded, by
	 * 	default [document] type uses
	 */
	public $type = 'document';

	/**
	 * @var string name of file status, that should loaded, by
	 * 	default [new] status uses
	 */
	public $status = 'new';

	public $tableClass = 'table table-striped table-hover doc-file-document-grid';

	public $columns = [
		'id' => '#',
		'name' => 'Название',
		'file_ext_id' => 'Расширение',
		'upload_date' => 'Дата загрузки',
		'upload_time' => 'Время загрузки'
	];

	public $footer = [
		'withPagination' => true,
		'withLimit' => true,
		'withSearch' => false,
	];

	public $pagination = [
		'pageSize' => 100,
		'page' => 0
	];

	public $sort = [
		'attributes' => [
			'id', 'name', 'file_ext_id', 'upload_date', 'upload_time'
		],
		'orderBy' => [
			'upload_date' => SORT_DESC,
			'upload_time' => SORT_DESC
		]
	];

	public $search = [
		'attributes' => [
			'name', 'upload_date', 'upload_time'
		]
	];

	public $limits = [
		100, 200, 300
	];

	public $fetcher = 'app\models\doc\File';

	public function getQuery() {
		return File::find()->where('file_type_id = :file_type_id and file_status_id = :file_status_id', [
            ':file_type_id' => $this->type, ':file_status_id' => 'new'
        ]);
	}
}