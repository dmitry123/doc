<?php

namespace app\models;

use app\core\FormModel;
use app\forms\DocumentForm;
use yii\db\ActiveRecord;

class Document extends \app\core\ActiveRecord {

	public static function tableName() {
		return "doc.document";
	}
}