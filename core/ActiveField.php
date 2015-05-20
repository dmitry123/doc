<?php

namespace app\core;

class ActiveField extends \yii\bootstrap\ActiveField {

    public function renderEx($type, $field, array $options = []) {
        if ($type == "dropdown" || $type == "multiple") {
            return $this->$field([
                0 => "Нет"
            ], $options);
        } else {
            return $this->$field($options);
        }
    }

    public function numberInput(array $options = []) {
        return $this->input("number", $options);
    }

    public function booleanInput(array $options = []) {
        return $this->dropDownList([
            0 => "Нет",
            1 => "Да"
        ], $options);
    }

    public function dateInput(array $options = []) {
        return $this->input("date", $options);
    }

    public function timeInput(array $options = []) {
        return $this->input("time", $options);
    }

    public function multipleInput(array $items, array $options = []) {
        return $this->dropDownList($items, [ "multiple" => true ] + $options);
    }

    public function emailInput(array $options = []) {
        return $this->input("email", $options);
    }

    public function phoneInput(array $options = []) {
        return $this->input("text", $options);
    }

    public function textAreaInput(array $options = []) {
        return $this->textarea($options);
    }

    public function radioInput(array $options = []) {
        return $this->radio($options);
    }

    public function fileInput(array $options = []) {
        return parent::fileInput($options + [
            "data-toggle" => "fileinput",
            "class" => "file-loading"
        ]);
    }

    public function systemInput(array $options = []) {
        return $this->dropDownList([
				0 => "Нет"
			] + TypeManager::getManager()->listSystem(), $options);
    }
}