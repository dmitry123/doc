<?php

namespace app\modules\doc\forms;

use app\core\Controller;
use app\core\FormModel;
use app\models\doc\Macro;
use app\models\doc\MacroColumn;
use yii\helpers\ArrayHelper;

class MacroForm extends FormModel {

    public $name;
    public $type;
    public $table;
    public $columns;
    public $value;

	public function rules() {
		return ArrayHelper::merge(parent::rules(), [
			[ "table", "required", "when" => function($model) {
				return $model->type == "dropdown";
			} ],
			[ "columns", "required", "when" => function($model) {
				return is_scalar($model->table) && (string) $model->table != "0";
			} ]
		]);
	}

	public function save() {
		$transaction = \Yii::$app->getDb()->beginTransaction();
		try {
			if (isset($this->value[$this->type])) {
				$this->value = $this->value[$this->type];
			} else {
				$this->value = null;
			}
			$ar = $this->getActiveRecord(true);
			$ar->setAttributes($this->getAttributes(), false);
			$r = $ar->save();
			foreach ($this->columns as $column) {
				$mc = new MacroColumn();
				$mc->setAttributes([
					"column" => $column,
					"macro_id" => $ar->{"id"}
				], false);
				if (!$mc->save()) {
					Controller::postErrors($mc);
				}
			}
			$transaction->commit();
			return $r;
		} catch (\Exception $e) {
			$transaction->rollBack();
			throw $e;
		}
	}

    public function createActiveRecord() {
        return new Macro();
    }
}