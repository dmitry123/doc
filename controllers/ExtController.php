<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Ext;
use app\core\ExtFactory;
use app\core\Module;
use app\core\PageFactory;
use app\core\GridProvider;
use app\core\Widget;
use yii\base\Exception;

class ExtController extends Controller {

	public function actionLoad() {
		try {
			$module = $this->requireQuery('module');
			$id = $this->requireQuery('ext');
			$params = $this->getQuery('params', []);
			if (!$ext = ExtFactory::getFactory()->createEx($module, $id, $params)) {
				$this->error('Расширение не поддерживается этим модулем');
			}
			ob_start();
			$r = $ext->invoke();
			if ($r === false) {
				ob_clean();
				$this->error('Расширение не поддерживается этим модулем');
			} else {
				print $r;
			}
			\Yii::$app->getSession()->set('ext', [
				'module' => $module,
				'id' => $id,
				'params' => $params,
			]);
			$this->leave([
				'component' => ob_get_clean(),
				'requires' => [
					'js' => $ext->js,
					'css' => $ext->css,
				]
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	public function actionWidget() {
		try {
			$module = \Yii::$app->getModule($this->requireQuery('module'));
            $class = $this->requireQuery('class');
			if ($module instanceof Module) {
				$class = $module->getWidgetClass($class);
			} else {
				$class = "app\\widgets\\".$class;
			}
			$widget = $this->createWidget($class, $this->getQuery('config', []));
			if (!$widget instanceof Widget) {
				throw new Exception('Loaded widget must be an instance of [app\core\Widget] class');
			}
			ob_start();
			print $widget->run();
			$this->leave([
				'component' => ob_get_clean()
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	public function actionTable() {
		try {
			$class = $this->requireQuery('provider');
			$config = $this->getQuery('config', [
				/* Default Table Configuration */
			]);
			foreach ($config as $key => &$value) {
                if (!is_array($value)) {
                    continue;
                }
				foreach ([ 'class', 'widget' ] as $k) {
					unset($value[$k]);
				}
			}
			/** @var $class GridProvider */
			$provider = new $class();
			foreach ($config as $key => &$value) {
				if (is_array($provider->$key)) {
					$provider->$key = $value + $provider->$key;
				} else {
					$provider->$key = $value;
				}
			}
			if (!$provider instanceof GridProvider) {
				throw new Exception('Table provider must be an instance of [app\core\Table] class');
			}
			$widget = $this->createWidget($this->requireQuery('widget'), [
				'provider' => $provider,
				'config' => $config
			]);
			if (!$widget instanceof Widget) {
				throw new Exception('Loaded widget must be an instance of [app\core\Widget] class');
			}
			ob_start();
			print $widget->run();
			$this->leave([
				'component' => ob_get_clean()
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	public function actionPanel() {
		try {
			$widget = $this->createWidget($this->requireQuery('widget'), $this->getQuery('config', []));
			if (!$widget instanceof Widget) {
				throw new Exception('Loaded widget must be an instance of [app\core\Widget] class');
			}
			ob_start();
			print $widget->run();
			$this->leave([
				'component' => ob_get_clean()
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}
}