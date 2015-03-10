<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use Yii;
use yii\base\Model;

class SiteController extends Controller {

	/**
	 * Main site index view action, it will display
	 * login form or main page with documents
	 * @return string - Rendered content
	 */
    public function actionIndex() {
		if (Yii::$app->getUser()->getIsGuest()) {
			return $this->render2("block", "login");
		} else {
			return $this->render2("main", "index");
		}
    }

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model Model - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return null;
	}
}
