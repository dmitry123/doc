<?php

namespace app\components\widgets;

class ConfirmModal extends Modal {

	/**
	 * @var string - Default delete title
	 */
	public $title = "Подтвердить удаление?";

	/**
	 * @var array - Default delete buttons
	 */
	public $buttons = [
		"confirm-delete-button" => [
			"text" => "Удалить",
			"class" => "btn btn-danger",
			"options" => [
				"data-dismiss" => "modal"
			],
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
	public $size = "modal-sm";

	/**
	 * @var string - Body content
	 */
	public $body = "Результат выполнения этого действия нельзя будет отменить. Вы точно уверены?";

	/**
	 * @var string - Body wrapper classes
	 */
	public $wrapper = "col-xs-12";

	/**
	 * Initialize modal window, but remove
	 * fade effect from this modal type
	 */
	public function init() {
		$this->options["class"] = "";
		parent::init();
	}
}