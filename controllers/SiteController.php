<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Module;
use app\core\ModuleHelper;
use Yii;

class SiteController extends Controller {

    public function actionIndex() {
		if (Yii::$app->getUser()->getIsGuest()) {
			return $this->render2("block", "login");
		}
		if (!Yii::$app->getSession()->has("EMPLOYEE_ID")) {
			return $this->render2("block", "employee");
		}
		if (Yii::$app->getSession()->has("ACTIVE_MODULE")) {
			$module = ModuleHelper::getModule(Yii::$app->getSession()->get("ACTIVE_MODULE"));
			if ($module != null) {
				return $this->render("index");
			}
			Yii::$app->getSession()->remove("ACTIVE_MODULE");
			return $this->actionIndex();
		}
		return $this->render2("block", "modules", [
			"modules" => ModuleHelper::getMenuModules()
		]);
    }

	public function actionSettings() {
		if (Yii::$app->user->isGuest) {
			return $this->render2("block", "login");
		} else {
			return $this->render2("block", "settings");
		}
	}

	public function actionRegister() {
		if (Yii::$app->user->isGuest) {
			return $this->render2("block", "register");
		} else {
			return $this->render2("block", "modules");
		}
	}
}
