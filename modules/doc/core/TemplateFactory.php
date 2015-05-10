<?php

namespace app\modules\doc\core;

use app\core\AbstractFactory;
use yii\base\Exception;

class TemplateFactory extends AbstractFactory {

	/**
	 * Produce instance of some component via
	 * your factory singleton instance
	 *
	 * @param $id int|string identification number
	 *    of your object, which will be produced
	 *
	 * @param $params array with class parameters
	 *    which copies to itself
	 *
	 * @return mixed instance of something
	 *
	 * @throws \yii\db\Exception
	 * @throws \Exception
	 */
	public function create($id, $params = []) {
		$lock = \Yii::$app->getDb()->beginTransaction();
		try {
			
			$lock->commit();
		} catch (Exception $e) {
			$lock->rollBack();
			throw $e;
		}
	}

	private function execute($command) {
		if (substr(php_uname(), 0, 7) == "Windows") {
			exec(".\\".$command);
		} else {
			exec($command);
		}
	}
}