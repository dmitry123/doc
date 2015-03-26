<?php

namespace app\widgets;

use app\assets\LogoAsset;
use app\core\EmployeeManager;
use app\core\Widget;
use yii\base\Exception;

class Logo extends Widget {

	/**
	 * @var string - Name of logo image (absolute)
	 */
	public $filename = "@web/img/logo-big.png";

	/**
	 * @var bool - Shall display user's identity with
	 * 	surname, name, patronymic and role name
	 */
	public $identity = true;

	/**
	 * @var array - Array with buttons, which should be
	 * 	displayed after logo
	 * Structure ('key' - is extra button class):
	 *  + [class] - basic button classes, default ('btn btn-default')
	 *  + text - button label
	 *  + [type] - button type, default ('button')
	 */
	public $buttons = [];

	/**
	 * Initialize widget
	 */
	public function init() {
		LogoAsset::register($this->getView());
		ob_start();
	}

	/**
	 * Run widget
	 */
	public function run() {
		$content = ob_get_clean();
		if (EmployeeManager::getManager()->isValid()) {
			$identity = EmployeeManager::getIdentity(
				EmployeeManager::SHORT
			);
		} else {
			$identity = null;
		}
		if (($info = EmployeeManager::getInfo()) != null && isset($info["role_name"])) {
			$role = $info["role_name"];
		} else {
			$role = null;
		}
		$buttons = [];
		foreach ($this->buttons as $key => &$button) {
			$options = [];
			if (!isset($button["text"])) {
				throw new Exception("Button must have text, found null");
			}
			if (isset($button["class"])) {
				$options["class"] = $button["class"]." $key";
			} else {
				$options["class"] = "btn btn-default $key";
			}
			if (isset($button["type"])) {
				$options["type"] = $button["type"];
			} else {
				$options["type"] = "button";
			}
			$buttons[] = [
				"options" => $options,
				"text" => $button["text"]
			];
		}
		return $this->render("Logo", [
			"self" => $this,
			"identity" => $identity,
			"role" => $role,
			"buttons" => $buttons,
			"content" => $content
		]);
	}
}