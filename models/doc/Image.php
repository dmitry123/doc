<?php

namespace app\models\doc;

use app\core\ViewTrait;

class Image extends File {

	use ViewTrait;

	public static function tableName() {
		return "doc.image";
	}
}