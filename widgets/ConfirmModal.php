<?php

namespace app\widgets;

use app\forms\UserForm;
use yii\bootstrap\Modal;

class ConfirmModal extends Modal {

	public function run() {
		return Modal::widget([
			"title" => "Подтвердить удаление?",
			"body" => new UserForm("delete"),
			"buttons" => [
				"delete" => [
					"text" => "Удалить",
					"class" => "btn btn-danger",
					"type" => "submit"
				]
			]
		]);
	}
}