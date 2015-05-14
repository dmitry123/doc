<?php

namespace app\components\forms;

use app\components\ActiveRecord;
use app\components\FormModel;
use app\models\core\User;

class UserForm extends FormModel {

	public $login;
	public $password;
	public $password2;
	public $email;
	public $access_token;

	public function rules() {
		return $this->getActiveRecord()->rules() + [

			[ [ "login", "password", "password2", "email" ], "required", "on" => "register" ],
			[ "login", "unique", "targetClass" => 'app\models\core\User', "on" => "register" ],
			[ [ "login", "password", "password2", "email" ], "required", "on" => "register" ],
			[ "password2", "compare", "compareAttribute" => "password", "on" => "register" ],

			[ [ "login", "password" ], "required", "on" => "login" ],
		];
	}

	/**
	 * @return ActiveRecord instance of active
	 * 	record class
	 */
	public function createActiveRecord() {
		return User::createWithModel($this);
	}
}