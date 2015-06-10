<?php

namespace app\core;

use yii\base\Object;
use yii\base\ViewContextInterface;
use yii\helpers\Html;

abstract class Ext extends Object implements ViewContextInterface {

	use ClassTrait;

	/**
	 * @var string identification number of current extension, don't
	 * 	change it, it won't take any effect (generates automatically)
	 */
	public $id = null;

	/**
	 * @var array with javascript files, that should be included after
	 * 	extension loaded
	 */
	public $js = [];

	/**
	 * @var array with css files, that should be included after
	 * 	extension loaded
	 */
	public $css = [];

	/**
	 * Render extension via it's view file
	 *
	 * @param $view string name of view file
	 * @param $params array with view parameters
	 *
	 * @return string with just rendered content
	 */
	public function render($view, $params = []) {
		$params += [ 'ext' => $this ];
		if (empty($this->id)) {
			$this->id = UniqueGenerator::generate('ext');
		}
		return Html::tag('div', \Yii::$app->getView()->render($view, $params, $this), [
			'class' => 'ext', 'id' => $this->id
		]);
	}

	/**
	 * Invoke some extensions's method by it's identifier
	 *
	 * @param $action string name of action to invoke
	 *
	 * @return mixed action result or null
	 */
	public function invoke($action = null) {
		if ($action === null) {
			$action = $this->_action;
		}
		if (method_exists($this, $action)) {
			return $this->$action();
		} else {
			return null;
		}
	}

	/**
	 * Prepare it's ext for next invocation
	 *
	 * @param $action string name of action
	 * 	to invoke later
	 *
	 * @return ExtAdapter
	 */
	public function prepare($action) {
		$this->_action = $action;
		return $this;
	}

	/**
	 * Returns the directory containing view files for
	 * current extension
	 *
	 * @return string the directory containing the view
	 * 	files for this widget.
	 */
	public function getViewPath() {
		return dirname((new \ReflectionClass($this))->getFileName()) .DIRECTORY_SEPARATOR. 'views' .DIRECTORY_SEPARATOR. $this->getID();
	}

	private $_action = null;
}