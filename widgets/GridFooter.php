<?php

namespace app\widgets;

use app\core\Widget;
use yii\helpers\Html;

class GridFooter extends Widget {

	/**
	 * @var \app\core\GridProvider class instance, which provides
	 * 	manipulations with ActiveRecord models
	 */
	public $provider = null;

	/**
	 * @var bool flag, which enables or disables
	 * 	displaying of pagination element
	 */
	public $withPagination = true;

	/**
	 * @var bool flag, which enables or disables
	 * 	displaying of search element
	 */
	public $withSearch = true;

	/**
	 * @var bool flag, which enables or disables
	 * 	displaying of element with limits
	 */
	public $withLimit = true;

	/**
	 * Render widget to return just rendered
	 * footer content for Grid widget
	 */
	public function run() {
		ob_start();
		print Html::beginTag("tfoot", [
			"class" => "table-footer"
		]);
		print Html::beginTag("tr");
		print Html::beginTag("td", [
			"colspan" => count($this->provider->columns) + ($this->provider->getMenu() != false ? 1 : 0),
			"class" => "col-xs-12 no-padding"
		]);
		print Html::beginTag("div", [
			"class" => "col-xs-9 text-left"
		]);
		if ($this->withPagination) {
			$this->renderPagination();
		}
		print Html::endTag("div");
		print Html::beginTag("div", [
			"class" => "col-xs-1 text-center"
		]);
		if ($this->withSearch) {
			$this->renderSearch();
		}
		print Html::endTag("div");
		print Html::beginTag("div", [
			"class" => "col-xs-2"
		]);
		if ($this->withLimit && count($this->provider->models) > 0) {
			$this->renderLimit();
		}
		print Html::endTag("div");
		print Html::endTag("td");
		print Html::endTag("tr");
		print Html::endTag("tfoot");
		return ob_get_clean();
	}

	public function renderPagination() {
		if ($this->provider->pagination != false && !empty($this->provider->models)) {
			print LinkPager::widget([
				"pagination" => $this->provider->getPagination(),
				"hideOnSinglePage" => false
			]);
		}
	}

	public function renderSearch() {
		print Html::tag("span", "", [
			"class" => "glyphicon glyphicon-search table-search-icon",
			"onmouseenter" => "$(this).tooltip('show')",
			"data-placement" => "left",
			"data-original-title" => "Поиск"
		]);
	}

	public function renderLimit() {
		if ($this->provider->limits !== false) {
			$list = [];
			foreach ($this->provider->limits as $value) {
				$list[$value] = $value;
			}
			if ($this->provider->getPagination() != null) {
				$limit = $this->provider->getPagination()->pageSize;
			} else {
				$limit = $this->provider->limits[0];
			}
			if ($limit !== null && !isset($list[$limit])) {
				$list = [ $limit => $limit ] + $list;
			} else if ($limit === null) {
				$limit = "";
			}
			print Html::dropDownList("limits", $limit, $list, [
				"class" => "form-control",
				"onchange" => "$(this).table('limit', $(this).val())"
			]);
		}
	}
}