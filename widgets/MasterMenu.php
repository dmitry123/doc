<?php

namespace app\widgets;

use app\core\ClassTrait;
use app\core\Module;
use app\core\ModuleHelper;
use app\core\Widget;
use yii\base\Object;

class MasterMenu extends Widget {

	/**
	 * @var string widget's identification
	 * 	number
	 */
	public $id;

	/**
	 * @var string name of extension that should
	 * 	be loaded for every module
	 */
	public $ext = null;

	/**
	 * @return string just rendered widget's
	 * 	content
	 */
	public function run() {
		return $this->render("MasterMenu", [
			"items" => $this->getItems(ModuleHelper::getMenuModules()),
			"id" => $this->id,
			"ext" => $this->ext
		]);
	}

	/**
	 * @param $modules array with modules [@see Module::getAllowedModules]
	 * @return array with items for menu
	 */
	public function getItems($modules) {
		$items = [];
		foreach ($modules as $module) {
			if ($module instanceof Object) {
				$class = ClassTrait::createID($module->className(), "module");
			} else if (isset($module["class"])) {
				$class = ClassTrait::createID($module["class"], "module");
			} else if (isset($module["id"])) {
				$class = ClassTrait::createID($module["id"]);
			} else {
				$class = null;
			}
			$items[] = [
				"label" => $module["name"],
				"data-module" => $class
			];
		}
		return $items;
	}
}