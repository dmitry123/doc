<?php

namespace app\controllers;

use app\core\Controller;
use app\core\ModuleHelper;
use Yii;

class SiteController extends Controller {

    public function actionIndex() {
		if (Yii::$app->getUser()->getIsGuest()) {
			return $this->renderEx("block", "login");
		}
		if (!Yii::$app->getSession()->has("EMPLOYEE_ID")) {
			return $this->renderEx("block", "employee");
		}
		if (Yii::$app->getSession()->has("ACTIVE_MODULE")) {
			$module = ModuleHelper::getModule(Yii::$app->getSession()->get("ACTIVE_MODULE"));
			if ($module != null) {
				return $this->render("index");
			}
			Yii::$app->getSession()->remove("ACTIVE_MODULE");
			return $this->actionIndex();
		}
		return $this->renderEx("block", "modules", [
			"modules" => ModuleHelper::getMenuModules()
		]);
    }

	public function actionSettings() {
		if (Yii::$app->user->isGuest) {
			return $this->renderEx("block", "login");
		} else {
			return $this->renderEx("block", "settings");
		}
	}

	public function actionRegister() {
		if (Yii::$app->user->isGuest) {
			return $this->renderEx("block", "register");
		} else {
			return $this->renderEx("block", "modules");
		}
	}
}
