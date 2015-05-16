<?php
/**
 * @var $this \yii\web\View
 * @var $model mixed
 */
$form = yii\bootstrap\ActiveForm::begin([
    "action" => Yii::$app->getUrlManager()->createUrl("doc/macro/create")
]);
print $form->field($model, "name", []);
$form->end();