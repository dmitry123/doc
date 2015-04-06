<?php
/**
 * @var Form $self - Self widget instance
 * @var View $this - Form widget instance
 * @var ActiveForm $form - Form widget
 * @var FormModel $model - Form model
 * @var string $id - Form identification value
 * @var string $url - Url for form submit
 */

use app\core\FormModel;
use app\widgets\Form;
use yii\web\View;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
	"enableClientValidation" => true,
	"enableAjaxValidation" => true,
	"options" => $self->options + [
		"id" => $id,
		"class" => "form-horizontal $self->class",
		"role" => "form",
		"data-form" => get_class($model),
		"data-widget" => get_class($this),
		"method" => "post"
	],
	"action" => $url
]); ?>

<?php foreach ($model->getConfig() as $key => $value): ?>
    <div class="form-group <?= $self->isHidden($key) ? "hidden" : "" ?>">
        <?php if (!$self->checkType($key, "Hidden") && $self->labels) : ?>
			<label class="col-xs-4 control-label" for="<?= $key ?>">
				<?= $value["label"] ?>
				<?php if (!empty($value["label"])): ?>
					<span class="required">*</span>
				<?php endif ?>
			</label>
        <?php endif; ?>
        <div class="col-xs-7">
            <?= $field = $self->prepare($key)->render($form, $model)->label(false)->render() ?>
        </div>
		<?php if ($field instanceof \app\core\FormControl): ?>
			<?php foreach ($field->getControls() as $class => $control): ?>
				<a href="javascript:void(0)">
					<?php $self->renderControl($class . " col-xs-1", $control); ?>
				</a>
			<?php endforeach; ?>
		<?php endif; ?>
    </div>
<?php endforeach; ?>

<?php if ($self->button != null): ?>
	<button class="<?= $self->button["class"] ?>" type="submit"><?= $self->button["text"] ?></button>
<?php endif; ?>

<?php ActiveForm::end() ?>