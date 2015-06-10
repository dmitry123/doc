<?php

namespace app\core;

use app\filters\AccessFilter;
use yii\base\Exception;

class ExtFactory extends AbstractFactory {

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
	 * @return ExtAdapter instance of extension component
	 * 	for module
	 *
	 * @throws Exception
	 */
	public function createEx($module, $id, $params = []) {
		if (count($id = explode('/', $id)) != 2) {
			$action = 'actionIndex';
		} else {
			$action = 'action'.$id[1];
		}
		$id = $id[0];
		if (!($class = ModuleHelper::createPath($module, 'extensions', $id)) || !class_exists($class)) {
			return null;
		} else if ($module = \Yii::$app->getModule($module)) {
			if (!$access = $module->getBehavior('access')) {
				throw new Exception('Can\t load module\'s access behavior');
			} else if (!$access instanceof AccessFilter) {
				throw new Exception('Access behavior must be an instance of [AccessFilter] class');
			} else if (!$access->validateModule($module)) {
				return null;
			}
		}
		/* @var $instance Ext */
		if (!($instance = \Yii::createObject([ 'class' => $class ] + $params)) instanceof Ext) {
			throw new Exception('Extension must be an instance of [app\\core\\Ext] class');
		}
		return $instance->prepare($action);
	}

	/**
	 * Try to load extension by it's identification number
	 * for some module
	 *
	 * @param $module string module identification
	 *  number
	 *
	 * @param $id string extension identification
	 *  number
	 *
	 * @param $default mixed default parameter, which
	 * 	returns if extension doesn't exists
	 *
	 * @param $params array with parameters which copies
	 *    to extension class
	 *
	 * @return mixed with content, that returns extension
	 *    or default value
	 *
	 * @throws Exception
	 */
	public function invoke($module, $id, $default = null, $params = []) {
		if ($ext = $this->createEx($module, $id, $params)) {
			return $ext->invoke();
		} else {
			return $default;
		}
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