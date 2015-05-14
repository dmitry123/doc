<?php

namespace app\core;

use app\filters\AccessFilter;
use yii\base\Exception;

class PageFactory extends AbstractFactory {

	/**
	 * Produce instance of some component via
	 * your factory singleton instance
	 *
	 * @param $module string name of module for
	 *    current component
	 *
	 * @param $id int|string identification number
	 *    of your object, which will be produced
	 *
	 * @param $params array with class parameters
	 *    which copies to itself
	 *
	 * @return mixed instance of something
	 *
	 * @throws Exception
	 */
	public function createEx($module, $id, $params = []) {
		if (!($class = ModuleHelper::createPath($module, "pages", $id)) || !class_exists($class)) {
			return null;
		} else if ($module = \Yii::$app->getModule($module)) {
			if (!$access = $module->getBehavior("access")) {
				throw new Exception("Can't load module's access behavior");
			} else if (!$access instanceof AccessFilter) {
				throw new Exception("Access behavior must be an instance of [AccessFilter] class");
			} else if (!$access->validateModule($module)) {
				return null;
			}
		}
		if (!($instance = \Yii::createObject([ "class" => $class ] + $params)) instanceof Page) {
			throw new Exception("Extension must be an instance of [app\\core\\Page] class");
		}
		return $instance;
	}

	/**
	 * Produce instance of some component via
	 * your factory singleton instance
	 *
	 * @param $id int|string identification number
	 *    of your object, which will be produced
	 *
	 * @param $params array with class parameters
	 *    which copies to itself
	 *
	 * @return mixed instance of something
	 */
	public function create($id, $params = []) {
		return $this->createEx(Module::currentModule(), $id, $params);
	}
}