<?php

namespace app\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\models\Employee;

class EmployeeController extends Controller {

	/**
	 * Returns a list of behaviors that this component should behave as.
	 *
	 * Child classes may override this method to specify the behaviors they want to behave as.
	 *
	 * The return value of this method should be an array of behavior objects or configurations
	 * indexed by behavior names. A behavior configuration can be either a string specifying
	 * the behavior class or an array of the following structure:
	 *
	 * ~~~
	 * 'behaviorName' => [
	 *     'class' => 'BehaviorClass',
	 *     'property1' => 'value1',
	 *     'property2' => 'value2',
	 * ]
	 * ~~~
	 *
	 * Note that a behavior class must extend from [[Behavior]]. Behavior names can be strings
	 * or integers. If the former, they uniquely identify the behaviors. If the latter, the corresponding
	 * behaviors are anonymous and their properties and methods will NOT be made available via the component
	 * (however, the behaviors can still respond to the component's events).
	 *
	 * Behaviors declared in this method will be attached to the component automatically (on demand).
	 *
	 * @return array the behavior configurations.
	 */
	public function behaviors() {
		return [
			"access" => [
				"class" => "app\\filters\\AccessFilter",
				"rules" => [
					"index" => [
						"on" => [ "user" ],
						"privileges" => [ "1", "2", "3" ],
						"roles" => [ "admin" ]
					]
				]
			]
		];
	}

	/**
	 * Display default employee page to register. If current user is
	 * guest or it already has employee, then it will be redirected
	 * to default home page
	 */
	public function actionIndex() {
		if (\Yii::$app->getUser()->getIsGuest()) {
			return $this->goHome();
		}
		$employee = Employee::model()->findOne([
			"user_id" => \Yii::$app->getUser()->getIdentity()->{"id"}
		]);
		if ($employee != null) {
			return $this->goHome();
		}
		return $this->render("index");
	}

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model FormModel - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return new Employee($model);
	}
}