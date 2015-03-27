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
	 * Define behaviors for admin module
	 * @return array - Array with configurations
	 */
	public function behaviors() {
		return [
			"access" => [
				"class" => "app\\filters\\AccessFilter",
				"rules" => [
					"roles" => $this->roles
				],
			]
		];
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
				if (in_array(EmployeeManager::getInfo()["role_id"], $module["roles"])) {
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