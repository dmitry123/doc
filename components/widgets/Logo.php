<?php

namespace app\components\widgets;

use app\assets\LogoAsset;
use app\components\EmployeeHelper;
use app\components\Widget;
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
	 * @var string|null content to render into
	 * 	logo widget
	 */
	public $body = null;

	/**
	 * Initialize widget
	 */
	public function init() {
		LogoAsset::register($this->getView());
		if ($this->body !== null) {
			ob_start();
		}
	}

	/**
	 * Run widget
	 */
	public function run() {
		if ($this->body !== null) {
			$content = $this->body;
		} else {
			$content = ob_get_clean();
		}
		if ($this->identity && EmployeeHelper::getHelper()->isValid()) {
			$identity = EmployeeHelper::getHelper()->getIdentity(EmployeeHelper::IDENTITY_SHORT);
		} else {
			$identity = null;
		}
		if (($info = EmployeeHelper::getHelper()->getInfo()) != null && isset($info["role_name"])) {
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