<?php
/**
 * Created by PhpStorm.
 * User: Savonin
 * Date: 2015-03-05
 * Time: 22:54
 */

namespace app\core;

class Widget extends \yii\base\Widget {

	/**
	 * Override that method to return just rendered component
	 * @param bool $return - If true, then widget shall return rendered component else it should print to output stream
	 * @return string - Just rendered component or nothing
	 */
	public function call($return = true) {
		if ($return) {
			ob_start();
		}
		$this->run();
		if ($return) {
			return ob_get_clean();
		}
		return null;
	}

	/**
	 * Executes the widget.
	 * This method is called by {@link CBaseController::endWidget}.
	 */
	public function run() {
		$this->render(__CLASS__, null, false);
	}
}