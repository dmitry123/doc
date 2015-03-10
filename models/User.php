<?php

namespace app\models;

use app\core\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {

	public $id;
	public $login;
	public $password;
	public $password2;
	public $email;
	public $register_date;
	public $access_token;

	/**
	 * Find model by it's name
	 * @return User - Active record class instance
	 */
	public static function model() {
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
	 * Get array with validation rules for current class
	 * @param $extra array - Additional validation rules (for hidden fields)
	 * @return array - Array with validation rules
	 */
	public static function getRules($extra = []) {
		if (!self::$rules) {
			return (self::$rules = array_merge(static::model()->rules(), $extra));
		} else {
			return self::$rules;
		}
	}

	private static $rules = null;

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
			->from("user")
			->where("lower(login) = :login")
			->andWhere("password = :password")
			->addParams([
				":login" => strtolower($login),
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
	 * @param int $id - User's identification number
	 * @return array|null - Array with user's information
	 */
	public function findById($id) {
		$row = static::find()
			->select("*")
			->from("user")
			->where("id = :id")
			->addParams([
				":id" => $id
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
		return User::model()->findById($id);
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
		return $this->login;
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
}
