<?php

namespace app\modules\admin\controllers;

use app\core\Controller;
use app\modules\admin\widgets\TablePanel;
use yii\helpers\Inflector;

class TableController extends Controller {

	/**
	 * Default view action
	 * @throws \Exception
	 */
	public function actionView() {
		try {
			print $this->render("view", [
				"self" => $this
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Load component with table for admin panel
	 * @throws \Exception
	 */
	public function actionLoad() {
		try {
			$table = Inflector::id2camel($this->requireQuery("table"), "_");
			$model = "app\\models\\$table";
			if (!class_exists($model)) {
				$this->error("Can't resolve table class \"$model\"");
			}
			$form = "app\\forms\\{$table}Form";
			if (!class_exists($form)) {
				$this->error("Can't resolve form model class \"$form\"");
			}
			$this->leave([
				"component" => TablePanel::widget([
					"model" => $model,
					"form" => $form
				])
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}
}