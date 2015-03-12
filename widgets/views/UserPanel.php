<?php

use app\models\Employee;
use app\models\User;
use app\widgets\UserPanel;
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
	<span class="glyphicon glyphicon-user"></span>
</div>
<div class="col-xs-12 text-center">
	<b><?= $user->{"login"} ?>&nbsp;(<?= $user->{"id"} ?>)</b>
</div>
<div class="col-xs-12">
	<span class="glyphicon glyphicon-filter"></span>
	<span class="glyphicon glyphicon-log-out"></span>
</div>