<?php

namespace app\core;

use yii\helpers\ArrayHelper;

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
	 * Initialize widget and generate it's own
	 * unique identification number
	 */
	public function init() {
		if (!empty($this->id)) {
			return;
		}
		$this->id = UniqueGenerator::generate(
			basename(get_called_class())
		);
	}

	/**
	 * Create url for widget's update for current module and controller
	 * @param array $query - Additional query GET parameters
	 * @return string - Url for widget update
	 */
	public function createUrl($query = []) {
		return preg_replace("/\\/[a-z0-9]*$/i", "/getWidget", \Yii::$app->getUrlManager()->createUrl(
			ArrayHelper::merge([ \Yii::$app->requestedRoute ], $query)
		));
	}

	/**
	 * Run widget to return just rendered content
	 * @return string - Just rendered content
	 */
	public function run() {
		return $this->render(preg_replace("/[.*~\\/]$/", __CLASS__, ""), []);
	}
}