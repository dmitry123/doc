<?php
/**
 * Created by PhpStorm.
 * User: Savonin
 * Date: 2015-03-07
 * Time: 20:54
 */

namespace app\module\admin\controllers;

use app\core\ActiveRecord;
use app\core\Controller;

class TestController extends Controller {

	public function actionView() {
		print "123";
	}

	/**
	 * Override that method to return model for
	 * current controller instance or null
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel() {
		return null;
	}
}