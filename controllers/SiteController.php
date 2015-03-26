<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\Module;
use Yii;
use yii\base\Exception;
use yii\base\Model;

class SiteController extends Controller {

	/**
	 * Main site index view action, it will display
	 * login form or main page with documents
	 * @return string - Rendered content
	 * @throws Exception
	 */
    public function actionIndex() {
		if (Yii::$app->getUser()->getIsGuest()) {
			return $this->render2("block", "login");
		}
		if (!Yii::$app->getSession()->has("EMPLOYEE_ID")) {
			return $this->render2("block", "employee");
		}
		if (Yii::$app->getSession()->has("ACTIVE_MODULE")) {
			$module = Module::getAllowedModules(Yii::$app->getSession()->get("ACTIVE_MODULE"));
			if ($module != null) {
				return $this->render("index");
			}
			Yii::$app->getSession()->remove("ACTIVE_MODULE");
			return $this->actionIndex();
		}
		return $this->render2("block", "modules", [
			"modules" => Module::getAllowedModules()
		]);
    }

	public function actionTest() {
		return $this->render2("block", "test");
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
