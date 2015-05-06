<?php

namespace app\widgets;

use yii\helpers\Html;

class LinkPager extends \yii\widgets\LinkPager {

	public $options = [
		"class" => "pagination pagination"
	];

	protected function renderPageButton($label, $page, $class, $disabled, $active) {
		$options = [
			'class' => $class === '' ? null : $class
		];
		if ($active) {
			Html::addCssClass($options, $this->activePageCssClass);
		}
		if ($disabled) {
			Html::addCssClass($options, $this->disabledPageCssClass);
			return Html::tag('li', Html::tag('span', $label), $options);
		}
		return Html::tag('li', Html::a($label, "javascript:void(0)", [
				"data-page" => $page,
				"onclick" => "$(this).table('page', '$page')"
			] + $this->linkOptions), $options);
	}
}