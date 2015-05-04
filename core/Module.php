<?php

namespace app\core;

use Yii;
use yii\base\Application;

class Module extends \yii\base\Module {

	use ClassTrait;

	/**
	 * @var string - Module name in russian
	 */
	public $name;

	/**
	 * @var string - Glyphicon class
	 */
	public $icon;

	/**
	 * @var array - Allowed privileges for that module
	 */
	public $privileges = [];

	/**
	 * @var array - Allowed roles for that module
	 */
	public $roles = [];

	/**
	 * @var string - Module entry url (relative path without web)
	 */
	public $url = null;

	/**
	 * @var string - Url to image icon
	 */
	public $image = null;

	/**
	 * @var array - Array with menu lists with next structure (value's is is HTML id):
	 *  + label - Displayable item's name
	 *  + [url] - Item's url to go
	 *  + [items] - Element's children for dropdown lists
	 *  + [options] - Array with HTML options
	 *  + [icon] - Glyphicon
	 */
	public $menu = [];

	/**
	 * Define behaviors for admin module
	 * @return array - Array with configurations
	 */
	public function behaviors() {
		return [
			"access" => [
				"class" => "app\\filters\\AccessFilter",
				"roles" => $this->roles,
				"privileges" => $this->privileges
			]
		];
	}

	/**
	 * Get name of current module
	 * @return string - Name of module
	 */
	public static function getModuleName() {
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

	/**
	 * Get array with allowed modules for current employee
	 * @param string $module - Name of module to fetch config
	 * @return array - Array with modules for current employee
	 */
	public static function getAllowedModules($module = null) {
		$modules = Yii::$app->getModules(false);
		$allowed = [];
		$array = [];
		foreach ($modules as $module) {
			if (!is_array($module)) {
				$m = [];
				foreach ($module as $key => $value) {
					$m[$key] = $value;
				}
				$array[] = $m;
			} else {
				$array[] = $module;
			}
		}
		foreach ($array as $module) {
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
			if (isset($module["roles"])) {
				if (in_array(EmployeeHelper::getHelper()->getInfo()["role_id"], $module["roles"])) {
					$allowed[] = $module;
				}
			} else {
				$allowed[] = $module;
			}
		}
		if ($module != null && is_string($module)) {
			return isset($allowed[$module]) ? $allowed[$module] : null;
		}
		return $allowed;
	}
}