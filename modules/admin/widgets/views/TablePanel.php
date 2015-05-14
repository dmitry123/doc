<?php
/**
 * @var $this yii\web\View
 * @var $self app\modules\admin\widgets\TablePanel
 */

print \app\widgets\Modal::widget([
	"title" => "Добавить значение",
	"body" => \app\widgets\Form::widget([
		"model" => $self->form->copyOf("admin.table.register"),
		"id" => "table-save-form"
	]),
	"buttons" => [
		"save-button" => [
			"text" => "Сохранить",
			"class" => "btn btn-primary",
			"type" => "submit"
		]
	],
	"id" => "table-save-modal"
]);
print \app\widgets\Modal::widget([
	"title" => "Редактировать значение",
	"body" => \app\widgets\Form::widget([
		"model" => $self->form->copyOf("admin.table.update"),
		"id" => "table-update-form"
	]),
	"buttons" => [
		"update-button" => [
			"text" => "Сохранить",
			"class" => "btn btn-primary",
			"type" => "submit"
		]
	],
	"id" => "table-update-modal"
]); ?>

<?php if (!empty($self->form) && !empty($self->model)): ?>
	<?= \app\widgets\AutoTable::widget([
		"model" => $self->model,
		"form" => $self->form,
		"modelName" => $self->model->className()
	]) ?>
<?php endif ?>