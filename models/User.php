<?php

namespace app\models;

use app\core\FormModel;
use app\core\TableProvider;
use app\forms\UserForm;
use yii\web\IdentityInterface;

class User extends TableProvider implements IdentityInterface {

	public static function tableName() {
		return "core.user";
	}

	/**
	 * Find model by it's name
	 * @param string $class - Name of model class or null (default)
	 * @return User - Active record class instance
	 */
	public static function model($class = null) {
		return parent::model(__CLASS__);
	}

	/**
	 * Get user validation rules
	 * @return array - Array with validation rules
	 */
	public function rules() {
		return [
			// set required for identification number on update
			[ "id", "required", "on" => "update" ],

			// set maximum and minimum length for 'login' and 'email' fields (see db)
			[ [ "login", "email", "access_token" ], "string", "max" => 50 ],

			// set fields to required for register scenario
			[ [ "login", "password", "password2", "email" ], "required", "on" => "register" ],

			// set fields to required for login scenario
			[ [ "login", "password" ], "required", "on" => "login" ],

			// compare two passwords on register
			[ "password", "compare", "compareAttribute" => "password2", "on" => "register" ]
		];
	}

	/**
	 * Fetch user row from table by it's login and password
	 * @param string $login - Original user name
	 * @param string $password - Hashed password
	 * @return array|null - Array with user's row or
	 * 		null if user has not been found
	 */
	public function findByLoginAndPassword($login, $password) {
		$row = static::find()
			->select("*")
			->from("core.user")
			->where("lower(login) = :login", [
				":login" => strtolower($login)
			])
			->andWhere("password = :password", [
				":password" => $password
			])->one();
		if ($row !== false) {
			return $row;
		} else {
			return null;
		}
	}

	/**
	 * Find user in database by it's identification number
	 * @param int $login - User's identification number
	 * @return array|null - Array with user's information
	 */
	public function findByLogin($login) {
		$row = static::find()
			->select("*")
			->from("core.user")
			->where("login = :login")
			->addParams([
				":login" => $login
			])->one();
		if ($row !== false) {
			return $row;
		} else {
			return null;
		}
	}

	/**
	 * Finds an identity by the given ID.
	 * @param string|integer $id the ID to be looked for
	 * @return IdentityInterface the identity object that matches the given ID.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentity($id) {
		return User::model()->findByLogin($id);
	}

	/**
	 * Finds an identity by the given token.
	 * @param mixed $token the token to be looked for
	 * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
	 * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
	 * @return IdentityInterface the identity object that matches the given token.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		return null;
	}

	/**
	 * Returns an ID that can uniquely identify a user identity.
	 * @return string|integer an ID that uniquely identifies a user identity.
	 */
	public function getId() {
		return $this->{"login"};
	}

	/**
	 * Returns a key that can be used to check the validity of a given identity ID.
	 *
	 * The key should be unique for each individual user, and should be persistent
	 * so that it can be used to check the validity of the user identity.
	 *
	 * The space of such keys should be big enough to defeat potential identity attacks.
	 *
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 * @return string a key that is used to check the validity of a given identity ID.
	 * @see validateAuthKey()
	 */
	public function getAuthKey() {
		return null;
	}

	/**
	 * Validates the given auth key.
	 *
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 * @param string $authKey the given auth key
	 * @return boolean whether the given auth key is valid.
	 * @see getAuthKey()
	 */
	public function validateAuthKey($authKey) {
		return null;
	}

	/**
	 * Override that method to return form model for
	 * current class with configuration, form model
	 * must be an instance of app\core\FormModel and
	 * implements [config] method
	 * @return FormModel - Instance of form model
	 * @see FormModel::config
	 */
	public function getFormModel() {
		return new UserForm("table");
	}
}
