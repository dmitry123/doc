<?php

use app\models\Employee;
use app\models\User;
use app\components\widgets\UserPanel;
use yii\web\View;

/**
 * @var View $this
 * @var UserPanel $self
 * @var User $user
 * @var Employee $employee
 */

?>
<br>
<div class="col-xs-12 text-center user-info-header">
	<span class="glyphicon glyphicon-user glyphicon-45"></span>
	<br>
	<b><?= $user->{"login"} ?></b>
</div>
<div class="col-xs-12 text-center user-info-body">
</div>
<hr>
<div class="col-xs-12 user-info-footer text-center">
	<a href="<?= \yii\helpers\Url::toRoute("user/logout") ?>">
		<span class="text-center glyphicon glyphicon-off glyphicon-45" data-toggle="tooltip" data-placement="top" title="Выход"></span>
	</a>
</div>
