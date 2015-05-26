<?php
use app\models\doc\File;
/**
 * @var $file File
 */
?>
<div class="col-xs-5">
	<?= \app\widgets\Panel::widget([
		"title" => "Форма шаблона",
		"body" => \app\modules\doc\widgets\TemplateForm::create([
			"file" => $file
		]),
		"upgradable" => false
	]) ?>
</div>
<div class="col-xs-7">
	<?= \app\widgets\Panel::widget([
		"title" => "Предпросмотр",
		"body" => \yii\helpers\Html::tag("h3", "Не реализовано", [
			"class" => "text-center"
		]),
		"upgradable" => false
	]) ?>
</div>