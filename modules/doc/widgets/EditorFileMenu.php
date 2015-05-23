<?php

namespace app\modules\doc\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;

class EditorFileMenu extends Widget {

	public $items = [
		"builder-open-button" => [
			"label" => "Открыть",
			"icon" => "fa fa-folder-open-o"
		],
		"builder-save-button" => [
			"label" => "Сохранить",
			"icon" => "fa fa-save"
		],
		"builder-preview-button" => [
			"label" => "Предпросмотр",
			"icon" => "fa fa-file-text-o"
		],
		"builder-print-button" => [
			"label" => "Печать",
			"icon" => "fa fa-print"
		],
		"builder-element-button" => [
			"label" => "Элементы",
			"icon" => "fa fa-tags",
			"items" => [
				"builder-element-create-button" => [
					"label" => "Создать",
					"icon" => "fa fa-plus",
					"onclick" => "$('#builder-create-element-modal').modal('show')",
				],
				"builder-element-find-button" => [
					"label" => "Найти",
					"icon" => "fa fa-search",
					"onclick" => "$('#builder-find-element-modal').modal('show')",
				],
				"builder-element-edit-button" => [
					"label" => "Просмотреть",
					"icon" => "fa fa-pencil",
					"onclick" => "$('#builder-view-element-modal').modal('show')",
				],
			]
		],
		"builder-macros-button" => [
			"label" => "Макросы",
			"icon" => "fa fa-th",
			"items" => [
				"builder-macros-create-button" => [
					"label" => "Создать",
					"icon" => "fa fa-plus",
					"onclick" => "$('#builder-create-macro-modal').modal('show')",
				],
				"builder-macros-find-button" => [
					"label" => "Найти",
					"icon" => "fa fa-search",
					"onclick" => "$('#builder-find-macro-modal').modal('show')",
				],
				"builder-macros-edit-button" => [
					"label" => "Просмотреть",
					"icon" => "fa fa-pencil",
					"onclick" => "$('#builder-view-macro-modal').modal('show')",
				],
			]
		]
	];

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