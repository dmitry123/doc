<?php

namespace app\widgets;

use app\core\Widget;
use app\forms\LoginForm;
use Yii;

class NavigationLogin extends Widget {

	public function run() {
		return Form::widget([
			"model" => new LoginForm("login"),
			"options" => [
				"class" => "navbar-form navbar-right",
				"role" => "search",
				"style" => "margin-bottom: -2px"
			],
			"wrapper" => ".navigation-login-wrapper",
			"url" => Yii::$app->request->getBaseUrl() . "/user/register",
			"labels" => false,
			"button" => [
				"class" => "btn btn-primary",
				"text" => "Войти"
			]
		]);
	}
}