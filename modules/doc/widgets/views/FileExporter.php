<?php
/**
 * @var $file app\models\doc\File
 * @var $ext app\models\doc\FileExt
 */
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
?>
<div class="col-xs-6">
	<?= Html::dropDownList("ext", $ext->{"id"}, ArrayHelper::map(\app\models\doc\FileExt::find()->all(), "id", "ext"), [
		"class" => "form-control"
	]) ?>
</div>
<div class="col-xs-6">
	<?= \app\widgets\ControlMenu::widget([
		"controls" => [
			"file-template-manager-download-button" => [
				"class" => "btn btn-success btn-block",
				"label" => "Скачать",
				"icon" => "fa fa-download"
			]
		],
		"mode" => \app\widgets\ControlMenu::MODE_BUTTON
	]) ?>
</div>