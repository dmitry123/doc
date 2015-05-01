<?php

namespace app\widgets;

use app\assets\LogoAsset;
use app\core\EmployeeManager;
use app\core\Widget;
use yii\base\Exception;

class Logo extends Widget {

	/**
	 * @var string - Path to logo image (absolute)
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
	public $controls = [];

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
		if ($this->identity && EmployeeManager::getManager()->isValid()) {
			$identity = EmployeeManager::getManager()->getIdentity(EmployeeManager::IDENTITY_SHORT);
		} else {
			$identity = null;
		}
		if (($info = EmployeeManager::getManager()->getInfo()) != null && isset($info["role_name"])) {
			$role = $info["role_name"];
		} else {
			$role = null;
		}
		return $this->render("Logo", [
			"self" => $this,
			"identity" => $identity,
			"role" => $role,
			"content" => $content
		]);
	}
}