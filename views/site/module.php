<?
/**
 * @var $this View
 * @var $modules array
 */
use yii\web\View;
?>

<div class="col-xs-12">
	<? foreach ($modules as $module): ?>
		<div class="col-xs-6 module-cell">
			<div class="module-icon-wrapper">
				<span class="<?= $module["icon"] ?> module-icon"></span>
				<div class="module-title">
					<?= $module["name"] ?>
				</div>
			</div>
		</div>
	<? endforeach; ?>
</div>