<?php

namespace app\modules\service\controllers;

use app\core\Controller;
use app\core\Ext;
use app\core\UniqueGenerator;
use Yii;

class MainController extends Controller {

	/**
	 * Define behaviors for admin module
	 * @return array - Array with configurations
	 */
	public function behaviors() {
		return parent::behaviors() + [
			'access' => [
				'class' => 'app\filters\AccessFilter',
				'roles' => [ 'super', 'admin' ]
			]
		];
	}

	public function actionIndex() {
		return $this->actionView();
	}

	public function actionView() {
		return $this->render('view', [ 'self' => $this,
			'ext' => Yii::$app->getSession()->get('ext', null),
			'items' => $this->createMenuItems()
		]);
	}

	public function createMenuItems() {
		$ext = Yii::$app->getSession()->get('ext', null);
		if (count($array = explode('/', $ext['id'])) == 2) {
			$key = $array[1];
		} else {
			$key = null;
		}
		if ($ext != null) {
			$ext['key'] = $key;
		}
		/* @var $active Ext */
		$active = null;
		$tabs = \app\core\ModuleHelper::getTabModulesEx(function($id, $config) use ($ext, &$active) {
			$instance = \app\core\ExtFactory::getFactory()->createEx(
				$id, 'service/menu', [ /* default parameters */ ]
			);
			$menu = $instance ? $instance->invoke() : [];
			if ($ext != null && $ext['module'] == $id) {
				/* $config['options'] = [ 'class' => 'active' ]; */
			}
			$result = [];
			foreach ($menu as $k => $m) {
				if ($ext != null && $ext['key'] == $k) {
					if (isset($m['items']) && count($m['items']) > 0 && isset($ext['params']['action'])) {
						foreach ($m['items'] as $k2 => &$v2) {
							if ($k2 == $ext['params']['action']) {
								$v2['options'] = [ 'class' => 'active' ];
								break;
							}
						}
					} else {
						$m['options'] = [ 'class' => 'active' ];
					}
					$active = $instance;
				}
				$result[UniqueGenerator::generate('a')] = $m + [ 'data-ext' => $k ];
			}
			return $config + [ 'items' => $result, 'data-module' => $id ];
		});
		if ($active != null) {
			$depends = [ 'app\assets\SiteAsset' ];
			foreach ($active->js as $js) {
				$this->getView()->registerJsFile('@web/'.$js, [ 'depends' => $depends ]);
			}
			foreach ($active->css as $css) {
				$this->getView()->registerCssFile('@web/'.$css, [ 'depends' => $depends ]);
			}
		}
		return $tabs;
	}
}