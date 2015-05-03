<?php

namespace app\models\doc;

use app\core\ViewTrait;

class Document extends File {

	use ViewTrait;

	public static function tableName() {
		return "doc.document";
	}
}