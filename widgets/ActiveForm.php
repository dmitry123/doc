<?php

namespace app\widgets;

use app\core\ActiveField;
use yii\base\Model;

class ActiveForm extends \yii\bootstrap\ActiveForm {

	public $enableClientValidation = false;
	public $enableAjaxValidation = false;

	public $fieldClass = '\app\core\ActiveField';

    /**
     * Generates a form field. A form field is associated with a model and an attribute. It
     * contains a label, an input and an error message and use them to interact with end users
     * to collect their inputs for the attribute.
     *
     * @param Model $model the data model
     *
     * @param string $attribute the attribute name or expression
     *  about attribute expression.
     *
     * @param array $options the additional configurations for the field object
     *
     * @return ActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = []) {
        return parent::field($model, $attribute, $options);
    }
}