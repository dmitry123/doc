<?php

namespace app\modules\doc\controllers;

use app\core\ActiveField;
use app\core\ActiveRecord;
use app\core\Controller;
use app\core\Fetcher;
use app\core\PostgreSQL;
use app\models\doc\Macro;
use app\modules\doc\forms\MacroForm;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Inflector;

class MacroController extends Controller {

    public function actionDescribe() {
        try {
            if (!$t = PostgreSQL::matchTable($this->requireQuery("hash"))) {
                throw new Exception("Unresolved table hash \"". $this->requireQuery("hash") ."\"");
            }
            $schema = $t["schema"];
            $name = $t["name"];
            $class = "app\\models\\{$schema}\\".Inflector::id2camel($name, "_");
            if (!class_exists($class)) {
                throw new Exception("Can't resolve active record [$class]");
            } else {
                /** @var $ar ActiveRecord */
                $ar = new $class();
            }
            $labels = $ar->attributeLabels();
            $columns = PostgreSQL::findColumnNamesAndTypes($name, $schema);
            $data = [];
            foreach ($columns as $column) {
                if ($column["name"] == "id") {
                    continue;
                }
                if (isset($labels[$column["name"]])) {
                    $data[$column["name"]] = $labels[$column["name"]];
                } else {
                    $data[$column["name"]] = $column["name"];
                }
            }
            $this->leave([
                "component" => Html::dropDownList("MacroForm[columns]", null, $data, [
					"multiple" => "multiple"
				])
            ]);
        } catch (\Exception $e) {
            $this->exception($e);
        }
    }

    public function actionFetch() {
        try {
            if (!$t = PostgreSQL::matchTable($this->requireQuery("hash"))) {
                throw new Exception("Unresolved table hash \"". $this->requireQuery("hash") ."\"");
            } else {
                $type = $this->requireQuery("type");
                $columns = $this->requireQuery("columns");
            }
            if (empty($columns)) {
                $this->leave([
                    "empty" => true
                ]);
            }
            $data = Fetcher::fetchTable([
                "name" => $t["schema"].".".$t["name"],
                "format" => preg_replace('/([\w\d_]+)/', '%{$1}', implode(" ", $columns)),
                "key" => "id",
                "value" => implode(",", $columns)
            ]);
            if ($type == "multiple") {
                $options = [
                    "multiple" => "multiple"
                ];
            } else {
                $options = [];
            }
			$data = [ 0 => "Нет" ] + $data;
            $this->leave([
                "component" => Html::dropDownList("MacroForm[value][$type]", null, $data, $options + [
                    "class" => "form-control"
                ]),
				"type" => $type
            ]);
        } catch (\Exception $e) {
            $this->exception($e);
        }
    }

	public function actionNew() {
		try {
			$form = new MacroForm();
			if (!$form->load(\Yii::$app->request->bodyParams)) {
				throw new Exception("Can't load [MacroForm] client model");
			} else if (!$form->validate()) {
				$this->postErrors($form);
			} else if (!$form->save()) {
				$this->postErrors($form->getActiveRecord());
			} else {
				$this->leave([
					"message" => "Макрос успешно создан"
				]);
			}
		} catch (\Exception $e) {
			$this->exception($e);
		}
	}
}