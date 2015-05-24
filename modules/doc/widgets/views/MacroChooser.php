<?php
/**
 * @var $model app\modules\doc\forms\MacroChooseForm
 */
$form = \yii\bootstrap\ActiveForm::begin([
	'action' => Yii::$app->getUrlManager()->createUrl('doc/macro/load'),
	'enableClientValidation' => false
]);
print $form->field($model, 'type')->dropDownList(
	[ 0 => "Нет" ] + \app\models\doc\Macro::listStaticTypes()
);
print $form->field($model, 'macro', [
	'options' => [
		'class' => 'form-group',
		'style' => 'display: none;'
	]
])->dropDownList([ 0 => 'Нет' ]);
$form->end();