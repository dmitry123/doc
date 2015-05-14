<?php

namespace app\models\doc;

use app\components\ViewTrait;

class Template extends File {

	use ViewTrait;

	public static function tableName() {
		return "doc.template";
	}
}