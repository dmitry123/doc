<?php

namespace app\commands;

use app\models\core\Access;
use app\models\core\Module;
use app\models\core\Privilege;
use app\models\core\Role;
use app\models\core\User;
use Yii;
use yii\console\Controller;

class DefaultController extends Controller {

	public $defaultRoles = [
		'super' => [
			'name' => 'Супервайзер',
			'description' => 'Имеет полный доступ к системе'
		],
		'admin' => [
			'name' => 'Администратор',
			'description' => 'Может администрировать систему'
		]
	];

	public $defaultUsers = [
		'system' => [
			'email' => 'dmitry123@inbox.ru',
			'password' => 'super123',
			'surname' => 'Савонин',
			'name' => 'Дмитрий',
			'patronymic' => 'Александрович',
			'phone' => '+7 (916) 053-13-23',
			'role' => 'super'
		],
		'admin' => [
			'email' => 'nwtsoas@gmail.com',
			'password' => 'admin123',
			'surname' => 'Савонин',
			'name' => 'Дмитрий',
			'patronymic' => 'Александрович',
			'phone' => '+7 (916) 053-13-23',
			'role' => 'admin'
		]
	];

	public $modulePrivilege = [
		'id' => 'MODULE_ACCESS',
		'name' => 'Имеет доступ к модулю',
		'description' => 'Имеет доступ к модулю и ко всем разверешенным компонентам внтури него',
	];

	public function actionRole() {
		foreach ($this->defaultRoles as $id => $role) {
			if (Role::find()->where([ 'id' => $id ])->exists()) {
				continue;
			}
			(new \app\models\core\Role([
				"id" => $id,
				"description" => $role["description"],
				"name" => $role["name"]
			]))->save();
		}
	}

	public function actionUser() {
		foreach ($this->defaultUsers as $login => $user) {
			if (!User::find()->where([ 'login' => $login ])->exists()) {
				\app\core\UserHelper::registerUser($login, $user);
			}
		}
	}

	public function actionCladr() {
		$t = Yii::$app->getDb()->beginTransaction();
		$f = function($file) {
			$sql = file_get_contents($file);
			foreach (explode(";", $sql) as $query) {
				\Yii::$app->getDb()->createCommand(preg_replace("/[^a-zA-Z0-9].*INSERT/", "INSERT", $query))->execute();
			}
		};
		try {
			$f("doc/cladr_country.sql");
			$f("doc/cladr_region.sql");
			$f("doc/cladr_city.sql");
			$t->commit();
		} catch (\Exception $e) {
			$t->rollBack();
			file_put_contents("runtime/logs/default.txt", $e->getMessage());
			throw $e;
		}
	}

	public function actionModule() {
		if (isset(Yii::$app->params['modules'])) {
			$modules = Yii::$app->params['modules'];
		} else {
			return;
		}
		foreach ($modules as $id => $module) {
			if (Module::find()->where([ 'id' => $id ])->exists()) {
				continue;
			}
			if (isset($module['roles']) && !empty($module['roles'])) {
				$access = Access::createWithModel();
				$access->save();
				foreach ($module['roles'] as $role) {
					if (!Role::find()->where([ 'id' => $role ])->exists()) {
						continue;
					}
					$privilege = Privilege::createWithModel(strtoupper($id).'_'.$this->modulePrivilege);
					$privilege->save();
					
				}
			} else {
				$access = null;
			}
			Module::createWithModel([
				'access_id' => $access
			])->save();
		}
	}
}