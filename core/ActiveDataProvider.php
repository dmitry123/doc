<?php

namespace app\core;

use yii\data\Pagination;
use yii\db\ActiveQuery;

abstract class ActiveDataProvider extends \yii\data\ActiveDataProvider {

	/**
	 * @var array|false with extra information about columns that should be
	 *  fetched, it takes information about columns from active record configuration
	 *
	 * One query maybe associated with several models, so it might has
	 * one of next structures:
	 *
	 * 1. string name of active record class (string)
	 * 2. array with names, where key is index of model (string[])
	 * 3. array with configured models, where every field
	 * 	associated with it's model (array key is class name of AR)
	 *
	 * Example:
	 *
	 * <code>
	 *
	 * // Fetch as name of model class
	 * public $fetcher = 'app\models\User';
	 *
	 * // Fetcher as list with possible models
	 * public $fetcher = [
	 * 		'app\models\User',
	 * 		'app\models\Role'
	 * ];
	 *
	 * // Fetcher as configured fields
	 * public $fetcher = [
	 * 		'app\models\User' => [
	 * 			"id", "login", "email"
	 * 		],
	 * 		'app\models\Role' => [
	 * 			"name", "description"
	 * 		]
	 * ];
	 *
	 * </code>
	 */
	public $fetcher = false;

	/**
	 * @var array|false with configuration for Pagination
	 *  object, see parent's definition for more information
	 *
	 * @see Pagination
	 */
	public $pagination = [
		"pageSize" => 10,
		"page" => 0
	];

	/**
	 * @var array|false with configuration for Sort
	 *  object, see parent's definition for more information
	 */
	public $sort = [
		"attributes" => [
			"id"
		],
		"orderBy" => [
			"id" => SORT_ASC
		]
	];

	/**
	 * @var array|false with configuration for Search
	 *  provider class
	 *
	 * @see Search
	 */
	public $search = false;

	/**
	 * Initialize table component, it ensures pagination,
	 * sort classes and invokes parent's init method
	 */
	public function init() {
		parent::init();
		$this->query = $this->getQuery();
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
	 * That function fetch models from current ActiveQuery and
	 * checks for fetcher, if last exists, then it fetches automatically
	 * all extra information about all fields, likes dropdown
	 * arrays or foreign tables, see [fetcher] doc for more information
	 *
	 * @return array with prepared models
	 */
	protected function prepareModels(){
		$models = parent::prepareModels();
		if ($this->fetcher !== false) {
			$this->getFetcher()->fetch($models);
		}
		return $models;
	}

	/**
	 * Get instance of sort class component for
	 * current table provider
	 *
	 * @return Sort class instance
	 */
	public function getSort() {
		if (!$this->_sort) {
			return $this->setSort($this->sort);
		} else {
			return $this->_sort;
		}
	}

	public function setSort($sort) {
		return $this->_sort = ObjectHelper::ensure($sort, Sort::className());
	}

	public function getPagination() {
		if ($this->_pagination == null) {
			return $this->setPagination($this->pagination);
		} else {
			return $this->_pagination;
		}
	}

	public function setPagination($pagination) {
		return $this->_pagination = ObjectHelper::ensure($pagination, Pagination::className());
	}

	/**
	 * Get new or cached instance of fetcher class, which providers
	 * action with data fetch from another foreign tables or
	 * simple dropdown lists
	 *
	 * @return Fetcher class instance
	 */
	public function getFetcher() {
		if ($this->_fetcher == null) {
			return $this->_fetcher = new Fetcher([
				"fetcher" => $this->fetcher
			]);
		} else {
			return $this->_fetcher;
		}
	}

	private $_pagination = null;
	private $_sort = null;
	private $_fetcher = null;
}