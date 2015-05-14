<?php

namespace app\models\doc;

use app\core\ViewTrait;

class Template extends File {

	use ViewTrait;

	public static function tableName() {
		return "doc.template";
	}
}