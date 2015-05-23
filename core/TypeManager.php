<?php

namespace app\core;

class TypeManager {

	private $_types = [
        'text' => [
            'label' => 'Текстовое поле',
            'field' => 'textInput',
			'validator' => 'string',
        ],
        'number' => [
            'label' => 'Число',
            'field' => 'numberInput',
			'validator' => 'number',
        ],
		'boolean' => [
			'label' => 'Логический',
            'field' => 'booleanInput',
			'validator' => 'boolean',
		],
		'date' => [
			'label' => 'Дата',
            'field' => 'dateInput',
			'validator' => 'date',
		],
        'time' => [
            'label' => 'Время',
            'field' => 'timeInput',
			'validator' => 'time',
        ],
		'dropdown' => [
			'label' => 'Выпадающий список',
            'field' => 'dropDownList'
		],
		'multiple' => [
			'label' => 'Множественный выбор',
            'field' => 'multipleInput'
		],
		'email' => [
			'label' => 'Почтовый ящик',
            'field' => 'emailInput',
			'validator' => 'email'
		],
		'file' => [
			'label' => 'Файл',
            'field' => 'fileInput',
			'validator' => 'file'
		],
		'hidden' => [
			'label' => 'Невидимое поле',
            'field' => 'hiddenInput'
		],
		'password' => [
			'label' => 'Пароль',
            'field' => 'passwordInput',
			'validator' => 'string'
		],
		'phone' => [
			'label' => 'Телефон',
            'field' => 'phoneInput',
			'validator' => 'phone'
		],
		'radio' => [
			'label' => 'Радио',
            'field' => 'radioInput'
		],
		'textarea' => [
			'label' => 'Текстовая область',
            'field' => 'textAreaInput'
		],
        'system' => [
            'label' => 'Системный',
            'field' => 'systemInput'
        ]
	];

    private $_system = [
        'SYSTEM_CURRENT_DATE' => [
            'label' => 'Текущая дата'
        ],
        'SYSTEM_CURRENT_TIME' => [
            'label' => 'Текущее время'
        ]
    ];

	private $_groups = [
		'list' => [ 'dropdown', 'multiple' ]
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
        if (isset($this->_types[$type]) && isset($this->_types[$type]['field'])) {
            return $this->_types[$type]['field'];
        } else {
            return null;
        }
    }

	/**
	 * Get name of class validator for that type
	 *
	 * @param $type string name of type for which validator
	 * 	should be created
	 *
	 * @param $model \yii\base\Model the data model to
	 * 	be validated
	 *
	 * @param $attributes array with list of attributes
	 * 	to be validated
	 *
	 * @return null|Validator with name of validator or null if that type
	 *    doesn't requires validation
	 */
	public function getValidator($type, $model, $attributes) {
		if (isset($this->_types[$type]) && isset($this->_types[$type]['validator'])) {
			return Validator::createValidator($this->_types[$type]['validator'], $model, $attributes);
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
			$list[$key] = $value['label'];
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
            $list[$key] = $value['label'];
        }
        return $list;
    }

	/**
	 * Test if some group includes type with it's name
	 *
	 * @param $group string name of group
	 * @param $type string name of type
	 *
	 * @return bool true if group contains that type
	 */
	public function test($group, $type) {
		return isset($this->_groups[$group]) && in_array($type, $this->_groups[$group]);
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