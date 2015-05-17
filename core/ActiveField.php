<?php

namespace app\core;

class ActiveField extends \yii\bootstrap\ActiveField {

    public function renderEx($type, $field, $options = []) {
        if ($type == "dropdown" || $type == "multiple") {
            return $this->$field([
                0 => "Нет"
            ], $options);
        } else {
            return $this->$field($options);
        }
    }

    public function numberInput($options = []) {
        return $this->input("number", $options);
    }

    public function booleanInput($options = []) {
        return $this->dropDownList([
            0 => "Нет",
            1 => "Да"
        ], $options);
    }

    public function dateInput($options = []) {
        return $this->input("date", $options);
    }

    public function timeInput($options = []) {
        return $this->input("time", $options);
    }

    public function multipleInput($items, $options = []) {
        return $this->dropDownList($items, [ "multiple" => true ] + $options);
    }

    public function emailInput($options = []) {
        return $this->input("email", $options);
    }

    public function phoneInput($options = []) {
        return $this->input("text", $options);
    }

    public function textAreaInput($options = []) {
        return $this->textarea($options);
    }

    public function radioInput($options = []) {
        return $this->radio($options);
    }

    public function fileInput($options = []) {
        return parent::fileInput($options + [
            "data-toggle" => "fileinput",
            "class" => "file-loading"
        ]);
    }

    public function systemInput($options = []) {
        return $this->dropDownList(TypeManager::getManager()->listSystem(), $options);
    }
}