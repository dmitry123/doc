<?php

namespace app\widgets;

use app\core\Module;
use app\core\Widget;
use app\models\core\Employee;
use app\models\core\Role;
use yii\helpers\Html;

class Navigation extends Widget {

	/**
	 * Run widget
	 * @return string - Rendered content
	 */
	public function run() {
		$identity = \Yii::$app->getUser()->getIdentity();
		$this->employee = Employee::findOne([
			"user_id" => $identity->{"id"}
		]);
		$module = \Yii::$app->controller->module;
		if ($module instanceof Module) {
			$menu = $module->menu;
		} else {
			$menu = [];
		}
		return $this->render("Navigation", [
			"admin" => $this->checkAccess("admin"),
			"menu" => $menu,
			"self" => $this
		]);
	}

	/**
	 * Render menu with items and sub-items, like in [Module::$menu]
	 * @param array $menu - Array with menu items
	 * @see app\core\Module::$menu
	 */
	public function renderItem($menu) {
		foreach ($menu as $key => $item) {
			if (isset($item["options"])) {
				$item["options"]["id"] = $key;
			} else {
				$item["options"] = [ "id" => $key ];
			}
			if (isset($item["options"]["href"])) {
				$item["options"]["href"] = \Yii::$app->getUrlManager()
					->createUrl($item["options"]["href"]);
			}
			if (!isset($item["url"])) {
				$item["url"] = "javascript:void(0)";
			}
			if (isset($item["icon"])) {
				$item["label"] = Html::tag("span", "&#8196;", [
						"class" => $item["icon"]
					]) . $item["label"];
			}
			if (isset($item["items"])) {
				$item["options"] += [
					"class" => "dropdown-toggle",
					"data-toggle" => "dropdown",
					"role" => "button",
					"aria-expanded" => "false"
				];
				$item["label"] = $item["label"] ."&nbsp;". Html::tag("span", Html::tag("span", "", [
						"class" => "sr-only"
					]), [
						"class" => "caret"
					]);
			} else {
				$item["items"] = [];
			}
			$c = [];
			if (isset($item["items"]) && count($item["items"]) > 0) {
				$c["class"] = "dropdown";
			}
			print Html::beginTag("li", $c);
			print \yii\helpers\Html::tag("a", $item["label"], $item["options"] + [
					"href" => \Yii::$app->getUrlManager()->createUrl($item["url"])
				]);
			if (isset($item["items"]) && count($item["items"]) > 0) {
				print Html::beginTag("ul", [
					"class" => "dropdown-menu",
					"role" => "menu"
				]);
				$this->renderItem($item["items"]);
				print Html::endTag("ul");
			}
			print Html::endTag("li");
		}
	}

	/**
	 * Check employee access
	 * @param array|string $roles - Array with roles or string with role id
	 * @return bool - False on access denied
	 */
	private function checkAccess($roles) {
		if ($this->employee != null) {
			return Role::checkEmployeeRoles($this->employee->{"id"}, $roles);
		} else {
			return false;
		}
	}

	private $employee;
}