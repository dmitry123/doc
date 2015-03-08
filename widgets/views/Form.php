<?
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
	"options" => [
		"id" => $id,
		"class" => "form-horizontal col-xs-12",
		"action" => $url,
		"role" => "form",
		"data-form" => get_class($model),
		"data-widget" => get_class($this)
	]
]); ?>

<? foreach ($model->getConfig() as $key => $value): ?>
    <div class="form-group <?= $self->isHidden($key) ? "hidden" : "" ?>">
        <?php if (!$self->checkType($key, "Hidden")) : ?>
			<label class="col-xs-3 control-label" for="<?= $key ?>"><?= $value["label"] ?></label>
        <? endif; ?>
        <div class="col-xs-8">
            <?= $field = $self->prepare($key)->render($form, $model)->label(false)->render() ?>
        </div>
		<? if ($field instanceof \app\core\FormControl): ?>
			<? foreach ($field->getControls() as $class => $control): ?>
				<a href="javascript:void(0)">
					<? $self->renderControl($class . " col-xs-1", $control); ?>
				</a>
			<? endforeach; ?>
		<? endif; ?>
        <? if ($self->checkType($key, "DropDown") && $self->getForm($key)): ?>
            <a data-form="<?= $self->getForm($key) ?>" href="javascript:void(0)">
				<span style="font-size: 15px; margin-left: -15px; margin-top: 5px" class="col-xs-1 glyphicon glyphicon-plus form-search-button"></span>
			</a>
        <? elseif ($self->checkType($key, "Multiple")): ?>
            <a href="javascript:void(0)"><span style="font-size: 15px; margin-left: -15px; margin-top: 5px" class="col-xs-1 glyphicon glyphicon-arrow-up form-up-button"></span></a>
            <a href="javascript:void(0)"><span style="font-size: 15px; margin-left: -15px; margin-top: 5px" class="col-xs-1 glyphicon glyphicon-arrow-down form-down-button"></span></a>
        <? endif; ?>
    </div>
<? endforeach; ?>

<? ActiveForm::end(); ?>