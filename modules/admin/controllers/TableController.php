<?php

namespace app\modules\admin\controllers;

use app\core\ActiveRecord;
use app\core\Controller;
use app\core\FormModel;
use app\core\TableProviderAdapter;
use app\modules\admin\widgets\Table;
use yii\helpers\Inflector;

class TableController extends Controller {

	/**
	 * Default view action
	 * @throws \Exception
	 */
	public function actionIndex() {
		try {
			print $this->render("index", [
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
			$table = Inflector::id2camel($this->get("table"), "_");
			$model = "app\\models\\$table";
			if (!class_exists($model)) {
				$this->error("Can't resolve table class \"$model\"");
			}
			$form = "app\\forms\\{$table}Form";
			if (!class_exists($form)) {
				$this->error("Can't resolve form model class \"$form\"");
			}
			$this->leave([
				"component" => Table::widget([
					"provider" => TableProviderAdapter::createProvider(
						new $model(), new $form("table")
					)
				])
			]);
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}

	/**
	 * Override that method to return model for current controller instance or null
	 * @param $model FormModel - Another model to clone
	 * @return ActiveRecord - Active record instance or null
	 */
	public function getModel($model) {
		return null;
	}
}