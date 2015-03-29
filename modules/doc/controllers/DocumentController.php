<?php

namespace app\modules\doc\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\models\Document;
use app\modules\doc\core\FileUploader;

class DocumentController extends Controller {

	/**
	 *
	 */
	public function actionUpload() {
		try {
			FileUploader::getUploader()->upload($_FILES);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model FormModel - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return new Document();
	}
}