<?php

namespace app\widgets;

class ConfirmModal extends Modal {

	/**
	 * @var string - Default delete title
	 */
	public $title = "Подтвердить удаление?";

	/**
	 * @var array - Default delete buttons
	 */
	public $buttons = [
		"delete" => [
			"text" => "Удалить",
			"class" => "btn btn-danger",
			"type" => "submit"
		]
	];

	/**
	 * @var string - Default id for delete action
	 */
	public $id = "confirm-delete-modal";

	/**
	 * @var string - Modal window size class
	 */
	public $size = self::SIZE_SMALL;

	/**
	 * Run widget
	 */
	public function run() {
		return parent::run();
	}
}