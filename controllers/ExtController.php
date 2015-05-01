<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\core\Widget;
use yii\base\Exception;

class ExtController extends Controller {

	public function actionWidget() {
		try {
			if (!$class = \Yii::$app->request->getQueryParam("class")) {
				throw new Exception("Widget action requires [class] parameter");
			} else {
				$params = \Yii::$app->request->getQueryParam("attributes");
			}
			$widget = $this->createWidget($class, $params);
			if (!$widget instanceof Widget) {
				throw new Exception("Loaded widget must be an instance of [app\\core\\Widget] class");
			}
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
		return null;
	}
}