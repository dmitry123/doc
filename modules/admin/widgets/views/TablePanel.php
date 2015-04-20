<?php
/**
 * @var $this yii\web\View
 * @var $self app\modules\admin\widgets\TablePanel
 */
if (empty($self->form)) {

} else {

}

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

<div class="panel panel-default table-view">
	<div class="panel-heading row">
		<div class="col-xs-12">
			<div class="col-xs-6">Список текущих значений</div>
			<div class="col-xs-6 text-right">
				<button id="table-save-button" class="btn btn-primary btn-xs">
					<span class="glyphicon glyphicon-plus"></span> Добавить
				</button>
			</div>
		</div>
	</div>
	<div class="panel-body table-widget">
		<?php if (!empty($self->form)): ?>
			<?= \app\widgets\AutoTable::widget([
				"form" => $self->form
			]) ?>
		<?php endif ?>
	</div>
</div>