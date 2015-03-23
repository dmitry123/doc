<?php

namespace app\widgets;

use app\assets\ModuleMenuAsset;
use app\core\Module;
use app\core\Widget;
use Yii;
use yii\web\Application;

class ModuleMenu extends Widget {

	public $absolute = true;

	public function init() {
		$this->getView()->registerAssetBundle(ModuleMenuAsset::className());
	}

	public function run() {
		$modules = Module::getAllowedModules();
		foreach ($modules as $i => $module) {
			if (!isset($module["options"]) || !isset($module["options"]["data-url"])) {
				continue;
			}
			if (Yii::$app->controller->route != $module["options"]["data-url"]) {
				continue;
			}
			array_splice($module, $i, 1);
			break;
		}
		return $this->render("ModuleMenu", [
			"modules" => $modules,
			"name" => $this->getModuleName(),
		]);
	}

	public function getModuleName() {
		if (($module = Yii::$app->controller->module) instanceof Application) {
			return "";
		}
		if ($module instanceof Module) {
			$name = $module->name;
		} else {
			$name = $module->id;
		}
		if ($name != "basic" && !empty($name)) {
			return ".".$name ;
		} else {
			return "";
		}
	}
}