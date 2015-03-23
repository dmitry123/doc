<?
/**
 * @var $this View
 * @var $modules array
 */
use yii\web\View;

print \app\widgets\Form::widget([
	"model" => new \app\forms\RoleForm()
]);