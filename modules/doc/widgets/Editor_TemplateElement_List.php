<?php

namespace app\modules\doc\widgets;

use app\core\TypeManager;
use app\core\Widget;
use app\modules\doc\core\ElementManager;
use yii\base\Exception;

class Editor_TemplateElement_List extends Widget {

	/**
	 * @var TypeManager|string instance of type manager or
	 * 	class with it's name
	 */
	public $manager = null;

	public function init() {
		if (empty($this->manager)) {
			throw new Exception("Type manager mustn't be empty value");
		} else if (is_string($this->manager)) {
			/** @var $manager TypeManager */
			$manager = $this->manager;
			$this->manager = $manager::getManager();
		}
		if (!$this->manager instanceof TypeManager) {
			throw new Exception("Type manager must be an instance of [app\\core\\TypeManager] class");
		}
		parent::init();
	}

	public function run() {
		return $this->render("Editor_TemplateElement_List", [
			"items" => ElementManager::getManager()->listTypes()
		]);
	}

	public function getAttributes($attributes = null, $excepts = [], $string = null) {
		return parent::getAttributes($attributes, $excepts, [ "manager" ]);
	}
}