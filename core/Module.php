<?php

namespace app\core;

use Yii;
use yii\helpers\Url;

class Module extends \yii\base\Module {

	/**
	 * @var string - Module name in russian
	 */
	public $name;

	/**
	 * @var string - Glyphicon class
	 */
	public $icon;

	/**
	 * @var array - Allowed roles for that module
	 */
	public $roles = null;

	/**
	 * @var string - Module entry url (relative path without web)
	 */
	public $url = null;

	/**
	 * Get array with allowed modules for current employee
	 * @return array - Array with modules for current employee
	 */
	public static function getAllowedModules() {
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
				if (in_array(EmployeeManager::getInfo()["role_id"], $module["roles"])) {
					$allowed[] = $module;
				}
			} else {
				$allowed[] = $module;
			}
		}
		return $allowed;
	}
}