<?
/**
 * @var $this View
 * @var $modules array
 */
use yii\web\View;
?>

<?php \app\widgets\Logo::begin([
	"controls" => [
		"modules-settings-button" => [
			"label" => "Настройки",
			"icon" => "glyphicon glyphicon-cog",
			"class" => "btn btn-primary btn-block",
			"type" => "button"
		],
		"modules-logout-button" => [
			"label" => "Выйти",
			"icon" => "glyphicon glyphicon-log-out",
			"class" => "btn btn-danger btn-block",
			"type" => "button"
		]
	]
]); ?>
<div class="col-xs-12 module-cell-wrapper">
<?php foreach ($modules as $module): ?>
	<div class="col-xs-6 module-cell">
		<div class="module-icon-wrapper" <?= \yii\helpers\Html::renderTagAttributes($module["options"]) ?>>
			<span class="<?= $module["icon"] ?> module-icon"></span>
			<div class="module-title">
				<?= $module["name"] ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<?php \app\widgets\Logo::end(); ?>