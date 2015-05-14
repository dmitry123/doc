<?php

namespace app\models\doc;

use app\components\ViewTrait;

class Table extends File {

	use ViewTrait;

	public static function tableName() {
		return "doc.table";
	}
}