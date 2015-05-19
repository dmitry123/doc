<?php

namespace app\core;

class TypeManager {

	private $_types = [
        "text" => [
            "label" => "Текстовое поле",
            "field" => "textInput"
        ],
        "number" => [
            "label" => "Число",
            "field" => "numberInput"
        ],
		"boolean" => [
			"label" => "Логический",
            "field" => "booleanInput"
		],
		"date" => [
			"label" => "Дата",
            "field" => "dateInput"
		],
        "time" => [
            "label" => "Время",
            "field" => "timeInput"
        ],
		"dropdown" => [
			"label" => "Выпадающий список",
            "field" => "dropDownList"
		],
		"multiple" => [
			"label" => "Множественный выбор",
            "field" => "multipleInput"
		],
		"email" => [
			"label" => "Почтовый ящик",
            "field" => "emailInput"
		],
		"file" => [
			"label" => "Файл",
            "field" => "fileInput"
		],
		"hidden" => [
			"label" => "Невидимое поле",
            "field" => "hiddenInput"
		],
		"password" => [
			"label" => "Пароль",
            "field" => "passwordInput"
		],
		"phone" => [
			"label" => "Телефон",
            "field" => "phoneInput"
		],
		"radio" => [
			"label" => "Радио",
            "field" => "radioInput"
		],
		"textarea" => [
			"label" => "Текстовая область",
            "field" => "textAreaInput"
		],
        "system" => [
            "label" => "Системный",
            "field" => "systemInput"
        ]
	];

    private $_system = [
        "SYSTEM_CURRENT_DATE" => [
            "label" => "Текущая дата"
        ],
        "SYSTEM_CURRENT_TIME" => [
            "label" => "Текущее время"
        ]
    ];

	/**
	 * Get singleton type manager's
	 * instance
	 *
	 * @return TypeManager class instance
	 */
	public static function getManager() {
		if (self::$_manager == null) {
			return self::$_manager = new TypeManager();
		} else {
			return self::$_manager;
		}
	}

	/**
	 * Get array with type manager types, you can
	 * override, but don't forget to invoke parent
	 * classes, like [parent::getTypes() + []]
	 *
	 * @return array with types for current class
	 */
	public function getTypes() {
		return $this->_types;
	}

    /**
     * Get name of type renderer, see ActiveField class
     * for more information about how to render field
     *
     * @param $type string name of type
     *
     * @return string|null name of render
     *  method
     */
    public function getField($type) {
        if (isset($this->_types[$type]) && isset($this->_types[$type]["field"])) {
            return $this->_types[$type]["field"];
        } else {
            return null;
        }
    }

	/**
	 * Get array with dropdown list for HTML select
	 * element
	 *
	 * @param $allowed array with allowed types that
	 * 	should be returned
	 *
	 * @return array with default list types optimized
	 *    for HTML select element
	 */
	public function listTypes(array $allowed = null) {
		$list = [];
		foreach ($this->_types as $key => $value) {
			if ($allowed != null && !in_array($key, $allowed)) {
				continue;
			}
			$list[$key] = $value["label"];
		}
		return $list;
	}

    /**
     * Get array with dropdown list for HTML select
     * element
     *
     * @return array with default list system types optimized
     * 	for HTML select element
     */
    public function listSystem() {
        $list = [];
        foreach ($this->_system as $key => $value) {
            $list[$key] = $value["label"];
        }
        return $list;
    }

	/**
	 * Locked, use [@see getManager] method to get
	 * single instance of TypeManager class
	 */
	private function __construct() {
		/* Locked */
	}

	private static $_manager = null;
}