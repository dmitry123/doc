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
	 * @return mixed instance of something
	 *
	 * @throws Exception
	 */
	public function createWithModule($module, $id, $params = []) {
		if (!($class = $this->createID($module, $id)) || !class_exists($class)) {
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
		if (!isset(static::$_cached[$class])) {
			if (!($instance = \Yii::createObject([ "class" => $class ] + $params)) instanceof Ext) {
				throw new Exception("Extension must be an instance of [app\\core\\Ext] class");
			} else {
				return static::$_cached[$class] = $instance;
			}
		} else {
			return static::$_cached[$class];
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
		return $this->createWithModule(Module::currentModule(), $id, $params);
	}

	public static function createID($module, $id) {
		if ($module = \Yii::$app->getModule($module)) {
			return preg_replace("/\\\\\\w+$/", "\\extensions\\{$id}Ext", $module->className());
		} else {
			return null;
		}
	}
}