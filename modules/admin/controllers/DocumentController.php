<?php

namespace app\modules\admin\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\models\Document;

class DocumentController extends Controller {

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model FormModel - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return new Document($model);
	}
}