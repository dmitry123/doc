<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\Module;
use Yii;
use yii\base\Model;

class SiteController extends Controller {

	/**
	 * Main site index view action, it will display
	 * login form or main page with documents
	 * @return string - Rendered content
	 */
    public function actionIndex() {
		if (!Yii::$app->getUser()->getIsGuest()) {
			if (!Yii::$app->getSession()->get("ACTIVE_MODULE")) {
				return $this->render2("block", "modules", [
					"modules" => Module::getAllowedModules()
				]);
			} else {
				return $this->render2("main", "index");
			}
		} else {
			return $this->render2("block", "login");
		}
    }

	/**
	 * Page for employee settings
	 * @return string - Rendered content
	 */
	public function actionSettings() {
		if (Yii::$app->getUser()->getIsGuest()) {
			return $this->render2("block", "login");
		} else {
			return $this->render2("block", "settings");
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
