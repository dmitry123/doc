<?php

namespace app\modules\doc\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;

class EditorFileMenu extends Widget {

	public $items = [];

	public function run() {
		return $this->render("EditorFileMenu", [
			"items" => $this->items,
            "self" => $this
		]);
	}

    public function renderItems(array $items, $root = true) {
        if (!$root) {
            print Html::beginTag("ul", [
                "class" => "dropdown-menu",
                "role" => "menu"
            ]);
        }
        foreach ($items as $c => $item) {
            if (isset($item["label"])) {
                $label = $item["label"];
            } else {
                $label = "";
            }
            if (isset($item["icon"])) {
                $label = Html::tag("span", "", [
                    "class" => $item["icon"]
                ]) ."&nbsp;". $label;
            }
            if (isset($item["items"])) {
                $list = $item["items"];
            } else {
                $list = "";
            }
            if (isset($item["href"])) {
                $href = $item["href"];
            } else {
                $href = "javascript:void(0)";
            }
            unset($item["label"]);
            unset($item["icon"]);
            unset($item["items"]);
            unset($item["href"]);
            print Html::beginTag("li");
            if ($list != null) {
                $caret = Html::tag("span", "", [
                    "class" => "caret"
                ]);
                print Html::a($label."&nbsp;".$caret, $href, $item + [
                    "class" => "dropdown-toggle $c",
                    "data-toggle" => "dropdown",
                    "role" => "button",
                    "aria-expanded" => "false"
                ]);
                $this->renderItems($list, false);
            } else {
                print Html::a($label, $href, $item + [
                    "class" => $c
                ]);
            }
            print Html::endTag("li");
        }
        if (!$root) {
            print Html::endTag("ul");
        }
    }
}