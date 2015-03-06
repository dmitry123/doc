<?php

namespace app\models;

use app\core\ActiveRecord;
use yii\db\ActiveQuery;

class User extends ActiveRecord {

	/**
	 * Override that method to return name of
	 * current table in database
	 * @return string - Name of table in database
	 */
	public function getTableName() {
		return "user";
	}

	/**
	 * Fetch user row from table by it's login and password
	 * @param string $login - Original user name
	 * @param string $password - Hashed password
	 * @return null|void
	 */
	public function fetchUserByLoginAndPassword($login, $password) {
		$row = $this->createQuery()
			->select("id")
			->from("user")
			->where("lower(login) = :login")
			->andWhere("password = :password")
			->createCommand()
			->queryOne();
		if ($row != null) {
		} else {
			return null;
		}
	}
}
