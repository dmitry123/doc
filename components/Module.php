<?php

namespace app\components;

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
				"class" => "app\\components\\filters\\AccessFilter",
				"roles" => $this->roles,
				"privileges" => $this->privileges
			]
		];
	}

	public static function currentModule() {
		return Yii::$app->controller->module->id;
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

	public function getWidgetClass($class) {
		return $this->getClassPath("widgets", $class);
	}

	private function getClassPath($scope, $class) {
		if (($p = strrpos($this->className(), "\\")) !== false) {
			return substr($this->className(), 0, $p) ."\\".$scope."\\".$class;
		} else {
			return "app\\".$scope."\\".$class;
		}
	}
}