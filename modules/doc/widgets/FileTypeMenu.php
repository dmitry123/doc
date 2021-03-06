<?php

namespace app\modules\doc\widgets;

use app\models\doc\FileType;
use app\widgets\TabMenu;
use yii\helpers\Html;

class FileTypeMenu extends TabMenu {

	public $style = self::STYLE_TABS_STACKED;
	public $id = "file-type-menu";

	public function init() {
		$types = FileType::findNotUnknown();
		foreach ($types as $type) {
			$this->items[] = [
				"label" => Html::tag("b", $type->name),
				"data-id" => $type->id
			];
		}
		parent::init();
	}
}