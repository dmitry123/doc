<?php
/**
 * @var $this yii\web\View
 * @var $self app\components\widgets\Logo
 * @var $identity string
 * @var $role string
 * @var $content string
 */
?>

<table>
<tbody>
<tr>
<td valign="middle" width="40%" align="middle">
	<div class="logo-wrapper text-center">
		<div class="logo-image-wrapper">
			<?= \yii\helpers\Html::img($self->filename, [
				"width" => "100%"
			]) ?>
		</div>
		<div class="logo-identity-wrapper col-xs-12">
			<?php if ($identity != null): ?><hr>
				<b><?= $identity ?></b>
				<br>
				<?= $role ?>
				<hr>
			<?php else: ?>
				<?php if (count($self->controls) > 0): ?>
					<hr>
				<?php endif ?>
			<?php endif ?>
		</div>
		<div class="logo-button-wrapper">
			<?= \app\components\widgets\ControlMenu::widget([
				"controls" => $self->controls,
				"mode" => \app\components\widgets\ControlMenu::MODE_BUTTON,
				"special" => "logo-control-button"
			]) ?>
		</div>
	</div>
</td>
<td width="25px"></td>
<td valign="middle" align="left">
	<?= $content ?>
</td>
</tr>
</tbody>
</table>