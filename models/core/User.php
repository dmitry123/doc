<?php

namespace app\models\core;

use app\core\ActiveRecord;
use app\core\FormModel;
use app\core\TableProvider;
use app\forms\UserForm;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {

	public function configure() {
		return [
			'id' => [
				'label' => 'Идентификатор',
				'type' => 'hidden',
				'rules' => 'integer'
			],
			'login' => [
				'label' => 'Логин',
				'type' => 'text',
				'rules' => 'required'
			],
			'password' => [
				'label' => 'Пароль',
				'type' => 'password',
				'rules' => 'required'
			],
			'password2' => [
				'label' => 'Повторите пароль',
				'type' => 'password'
			],
			'email' => [
				'label' => 'Почтовый ящик',
				'type' => 'email',
				'rules' => 'email'
			],
			'register_time' => [
				'label' => 'Время регистрации',
				'type' => 'text'
			],
			'register_date' => [
				'label' => 'Дата регистрации',
				'type' => 'text'
			],
			'access_token' => [
				'label' => 'Ключ доступа',
				'type' => 'hidden'
			],
			'security_key_id' => [
				'label' => 'Ключ безопасности',
				'type' => 'DropDown',
				'table' => [
					'name' => 'core.security_key',
					'key' => 'id',
					'value' => 'key'
				],
				'rules' => 'required'
			]
		];
	}

	public function rules() {
		return [
			[ [ 'login', 'email' ], 'string', 'max' => 50 ],
			[ [ 'access_token' ], 'string', 'max' => 20 ],
		];
	}

	public static function tableName() {
		return 'core.user';
	}

	/**
	 * Find user in database by it's identification number
	 * @param int $login - User's identification number
	 * @return array|null - Array with user's information
	 */
	public static function findByLogin($login) {
		$row = static::find()->select('*')->from('core.user')->where('login = :login', [
			':login' => strtolower($login)
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
		return static::findOne([
			'id' => $id
		]);
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
		return static::findOne([
			'access_token' => $token
		]);
	}

	/**
	 * Returns an ID that can uniquely identify a user identity.
	 * @return string|integer an ID that uniquely identifies a user identity.
	 */
	public function getId() {
		return $this->{'id'};
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
		return $this->{'login'};
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
		return true;
	}
}
