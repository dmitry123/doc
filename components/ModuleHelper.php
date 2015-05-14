<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\base\Application;

class ModuleHelper {

	public static function getModules() {
		if (static::$_modules != null) {
			return static::$_modules;
		}
		$modules = Yii::$app->getModules(false);
		$list = [];
		foreach ($modules as $id => $module) {
			if (!is_array($module)) {
				$m = [];
				foreach ($module as $key => $value) {
					$m[$key] = $value;
				}
				$list[$id] = $m;
			} else {
				$list[$id] = $module;
			}
		}
		return static::$_modules = $list;
	}

	public static function getAllowedModules() {
		if (static::$_allowed != null) {
			return static::$_allowed;
		}
		$allowed = [];
		foreach (static::getModules() as $id => $module) {
			if (isset($module["roles"])) {
				if (EmployeeHelper::hasRole($module["roles"])) {
					$allowed[$id] = $module;
				}
			} else {
				$allowed[$id] = $module;
			}
		}
		return $_allowed = $allowed;
	}

	public static function getModule($id, $allowed = true) {
		if ($allowed) {
			return static::getAllowedModules()[$id];
		} else {
			return static::getModules()[$id];
		}
	}

	public static function getHrefModules($allowed = true) {
		if ($allowed) {
			$modules = static::getAllowedModules();
		} else {
			$modules = static::getModules();
		}
		$list = [];
		foreach ($modules as $id => $module) {
			$attributes = [];
			if (isset($module["url"]) && !empty($module["url"])) {
				$attributes["href"] = Yii::$app->urlManager->createUrl($module["url"]);
			}
			if (isset($module["name"])) {
				$attributes["label"] = $module["name"];
			} else {
				$attributes["label"] = "";
			}
			if (isset($module["icon"])) {
				$attributes["label"] = Html::tag("span", "", [
					"class" => $module["icon"]
				]) ."&nbsp;&nbsp;". $attributes["label"];
			} else {
				$attributes["label"] = "";
			}
			$list[$id] = $attributes;
		}
		return $list;
	}

	public static function getHrefModulesEx(callable $callback, $allowed = true) {
		$modules = static::getHrefModules($allowed);
		foreach ($modules as $key => &$module) {
			$module = $callback($key, $module);
		}
		return $modules;
	}

	public static function getTabModules($allowed = true) {
		if ($allowed) {
			$modules = static::getAllowedModules();
		} else {
			$modules = static::getModules();
		}
		$list = [];
		foreach ($modules as $id => $module) {
			$attributes = [
				"onclick" => "$(this).next().slideToggle('normal')"
			];
			if (isset($module["url"]) && !empty($module["url"])) {
				$attributes["href"] = "javascript:void(0)";
				$attributes["data-href"] = $module["url"];
			}
			if (isset($module["name"])) {
				$attributes["label"] = $module["name"];
			} else {
				$attributes["label"] = "";
			}
			if (isset($module["icon"])) {
				$attributes["label"] = Html::tag("span", "", [
						"class" => $module["icon"]
					]) ."&nbsp;&nbsp;". $attributes["label"];
			} else {
				$attributes["label"] = "";
			}
			$list[$id] = $attributes;
		}
		return $list;
	}

	public static function getTabModulesEx(callable $callback, $allowed = true) {
		$modules = static::getTabModules($allowed);
		foreach ($modules as $key => &$module) {
			$module = $callback($key, $module);
		}
		return $modules;
	}

	public static function getMenuModules($allowed = true) {
		if ($allowed) {
			$modules = static::getAllowedModules();
		} else {
			$modules = static::getModules();
		}
		$list = [];
		foreach ($modules as $id => $module) {
			if (!isset($module["options"])) {
				$module["options"] = [];
			}
			if (!isset($module["url"]) || empty($module["url"])) {
				$module["options"] += [
					"data-error" => "not-implemented"
				];
			} else {
				$module["options"] += [
					"data-url" => $module["url"]
				];
			}
			$list[] = $module;
		}
		return $list;
	}

	public static function currentModuleName() {
		if (($module = Yii::$app->controller->module) instanceof Application) {
			return "";
		}
		if ($module instanceof Module) {
			$name = $module->name;
		} else {
			$name = $module->id;
		}
		if ($name != Yii::$app->id && !empty($name)) {
			return ".".$name ;
		} else {
			return "";
		}
	}

	private static $_modules = null;
	private static $_allowed = null;
}