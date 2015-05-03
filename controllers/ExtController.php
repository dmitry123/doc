<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Ext;
use app\core\ExtFactory;
use app\core\Widget;
use yii\base\Exception;

class ExtController extends Controller {

	public function actionLoad() {
		try {
			/** @var $ext Ext */
			$ext = ExtFactory::getFactory()->create(
				$this->requireQuery("module"),
				$this->requireQuery("ext"),
				$this->getQuery("params", [])
			);
			if (empty($ext)) {
				$this->error("Расширение не поддерживается этим модулем");
			}
			$this->leave([
				"component" => $ext->load()
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

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
			ob_start();
			print $widget->run();
			$this->leave([
				"component" => ob_get_clean()
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	public function actionTable() {
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

	public function actionPanel() {
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
}