<?php

namespace app\core;

use app\widgets\ControlMenu;
use app\widgets\GridFooter;
use yii\base\InvalidParamException;
use yii\db\ActiveQuery;

abstract class Table extends ActiveDataProvider {

	/**
	 * Default control menu display mode. To override it change
	 * control menu provider's field [mode]
	 *
	 * @see ControlMenu::mode
	 * @see menu
	 */
	const CONTROL_MENU_MODE = ControlMenu::MODE_ICON;

	/**
	 * Default control menu special class for menu items, it adds
	 * automatically to every menu item
	 *
	 * @see ControlMenu::special
	 * @see menu
	 */
	const CONTROL_MENU_SPECIAL = "table-control-icon";

	/**
	 * @var array with name of columns identifications
	 * 	which should be displayed
	 */
	public $columns = null;

	/**
	 * @var array|false with configuration for control menu
	 * 	widget, default class field is [ControlMenu]
	 * @see app\widgets\ControlMenu
	 */
	public $menu = false;

	/**
	 * @var array|false with configuration for Pagination
	 * object, see parent's definition for more
	 * information
	 *
	 * @see Pagination
	 */
	public $pagination = [
		"pageSize" => 10,
		"page" => 0
	];

	/**
	 * @var array|false with configuration for Search
	 *  provider class
	 *
	 * @see Search
	 */
	public $search = false;

	/**
	 * @var string name of model's primary key which
	 * 	copies to every <tr> element
	 */
	public $primaryKey = "id";

	/**
	 * @var array with list of available page
	 * 	limits
	 */
	public $limits = [
		1, 2, 5, 10, 25, 50, 75
	];

	/**
	 * @var string control menu elements alignment
	 */
	public $menuAlignment = "middle";

	/**
	 * @var bool should table be empty after first page load, set
	 * 	it to true if your table contains big amount of rows and
	 * 	it's initial render will slow down all render processes, also
	 * 	it removes table footer, cuz it should contains search parameters
	 *
	 * @see renderFooter
	 */
	public $emptyData = false;

	/**
	 * @var bool should widget renders table header with
	 * 	information columns names and order directions
	 */
	public $hasHeader = true;

	/**
	 * @var array|false with configuration for widget, that
	 * 	renders
	 */
	public $footer = [
		"withPagination" => true,
		"withSearch" => true,
		"withLimit" => true
	];

	/**
	 * @var bool should widget renders table footer with
	 * 	extra table control elements and count information
	 */
	public $hasFooter = true;

	/**
	 * @var string default table class which wraps table's
	 * 	header, body and footer
	 */
	public $tableClass = "table table-striped";

	/**
	 * @var string text message for received empty array
	 * 	with data
	 */
	public $textNoData = "Нет данных";

	/**
	 * @var string message will be displayed if
	 * 	field [emptyData] set to true
	 *
	 * @see emptyData
	 */
	public $textEmptyData = "Не выбраны критерии поиска";

	/**
	 * @var string default placement for bootstrap tooltip
	 * 	component [left, right, top, bottom]
	 */
	public $tooltipDefaultPlacement = "left";

	/**
	 * @var string width of column with control elements
	 */
	public $menuWidth = "50px";

	/**
	 * @var string identification string of current
	 * 	module, only for internal usage
	 *
	 * @internal changing that property may
	 * 	crash widget or do nothing
	 */
	public $module = null;

	/**
	 * @var string with name of glyphicon class for
	 * 	chevron order icon (DESC)
	 */
	public $chevronUpClass = "glyphicon glyphicon-chevron-up";

	/**
	 * @var string with name of glyphicon class for
	 * 	chevron order icon (ASC)
	 */
	public $chevronDownClass = "glyphicon glyphicon-chevron-down";

	/**
	 * @var string with javascript code which provides actions on
	 * 	row's click, you should set only function name, other method
	 *	call binds automatically
	 */
	public $clickEvent = null;

	/**
	 * @var string|callable with javascript code which provides
	 * 	actions on row's double click
	 */
	public $doubleClickEvent = null;

	/**
	 * Construct table configuration class for table
	 * widget with default query object
	 *
	 * @param $config array with class configuration
	 */
	public function __construct($config = []) {
		foreach ($config as $key => $value) {
			if (is_array($this->$key)) {
				$this->$key = $value + $this->$key;
			} else {
				$this->$key = $value;
			}
		}
		parent::__construct([ "query" => $this->getQuery() ]);
	}

	/**
	 * Override that method to return instance
	 * of ActiveQuery class
	 *
	 * @return ActiveQuery
	 */
	public abstract function getQuery();

	/**
	 * Override that method to return custom
	 * search query for Search provider
	 *
	 * @return ActiveQuery
	 */
	public function getSearchQuery() {
		return $this->getQuery();
	}

	/**
	 * Get control menu element, if it does not exist that it creates
	 * automatically with default parameters. Use [@see menu] field to
	 * check component existence
	 *
	 * @return ControlMenu class instance
	 */
	public function getMenu() {
		if (!$this->_menu) {
			return $this->setMenu([]);
		} else {
			return $this->_menu;
		}
	}

	/**
	 * Create control menu element with configuration
	 * array, it will pull it with default values
	 *
	 * @param $menu ControlMenu|array with menu configuration or
	 * 	instance of ControlMenu class
	 *
	 * @return ControlMenu class instance
	 */
	public function setMenu($menu) {
		if (is_array($menu)) {
			if (!isset($menu["mode"])) {
				$menu["mode"] = static::CONTROL_MENU_MODE;
			}
			if (!isset($menu["special"])) {
				$menu["special"] = static::CONTROL_MENU_SPECIAL;
			}
			$this->_menu = ObjectHelper::ensure($menu, ControlMenu::className());;
		} else if ($menu instanceof ControlMenu) {
			$this->_menu = $menu;
		} else {
			throw new InvalidParamException("Only instance of ControlMenu class, configuration array or false is allowed");
		}
		return $this->_menu;
	}

	/**
	 * Get footer element for grid widget, with
	 * displays extra control elements for grid footer
	 *
	 * @return ControlMenu class instance
	 */
	public function getFooter() {
		if (!$this->_footer) {
			return $this->setFooter([]);
		} else {
			return $this->_footer;
		}
	}

	/**
	 * Create control menu element with configuration
	 * array, it will pull it with default values
	 *
	 * @param $footer GridFooter|array with menu configuration or
	 * 	instance of ControlMenu class
	 *
	 * @return ControlMenu class instance
	 */
	public function setFooter($footer) {
		if (is_array($footer)) {
			if (!isset($footer["provider"])) {
				$footer["provider"] = $this;
			}
			$this->_footer = ObjectHelper::ensure($footer, GridFooter::className());;
		} else if ($footer instanceof GridFooter) {
			$this->_footer = $footer;
		} else {
			throw new InvalidParamException("Only instance of GridFooter class, configuration array or false is allowed");
		}
		return $this->_footer;
	}

	/**
	 * Initialize table component, it ensures pagination,
	 * sort classes and invokes parent's init method
	 */
	public function init() {
		if ($this->pagination != false) {
			$this->setPagination($this->pagination);
		}
		if ($this->sort != false) {
			$this->setSort($this->sort);
		}
//		if ($this->orderBy != false) {
//		}
		if ($this->menu != false) {
			$this->setMenu($this->menu);
		}
		if ($this->footer != false) {
			$this->setFooter($this->footer);
		}
		parent::init();
	}

	private $_footer = null;
	private $_menu = null;
}