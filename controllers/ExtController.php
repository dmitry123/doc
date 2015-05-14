<?php

namespace app\controllers;

use app\components\Controller;
use app\components\Ext;
use app\components\ExtFactory;
use app\components\Module;
use app\components\Table;
use app\components\Widget;
use yii\base\Exception;

class ExtController extends Controller {

	public function actionLoad() {
		try {
			/** @var $ext Ext */
			$ext = ExtFactory::getFactory()->createWithModule($this->requireQuery("module"),
				$this->requireQuery("ext"), $this->getQuery("params", [])
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
			if (!$module = \Yii::$app->request->getQueryParam("module")) {
				$module = \Yii::$app->controller->module;
			} else {
				$module = \Yii::$app->getModule($module);
			}
			if ($module instanceof Module) {
				$class = $module->getWidgetClass($class);
			} else {
				$class = "app\\widgets\\".$class;
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
			$class = $this->requireQuery("provider");
			$config = $this->getQuery("config", [
				/* Default Table Configuration */
			]);
			foreach ($config as $key => &$value) {
				foreach ([ "class", "widget" ] as $k) {
					unset($value[$k]);
				}
			}
			/** @var $class Table */
			$provider = new $class();
			foreach ($config as $key => &$value) {
				if (is_array($provider->$key)) {
					$provider->$key = $value + $provider->$key;
				} else {
					$provider->$key = $value;
				}
			}
			if (!$provider instanceof Table) {
				throw new Exception("Table provider must be an instance of [app\\core\\Table] class");
			}
			$widget = $this->createWidget($this->requireQuery("widget"), [
				"provider" => $provider,
				"config" => $config
			]);
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

	public function actionPanel() {
		try {
			$widget = $this->createWidget($this->requireQuery("widget"), $this->getQuery("config", []));
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
}