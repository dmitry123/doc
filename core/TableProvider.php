<?php

namespace app\core;

use Exception;
use yii\db\ActiveQuery;
use yii\db\Connection;
use yii\db\Query;

class TableProvider {

	/**
	 * @var ActiveRecord|string - Database active
	 * 	record instance or it's class name
	 */
	public $activeRecord = null;

	/**
	 * @var TablePagination|false - Table pagination
	 *	instance, set it to false to disable pagination
	 */
	public $pagination = null;

	/**
	 * @var ActiveQuery - Query to fetch data from
	 * 	database table for current provider
	 */
	public $fetchQuery = null;

	/**
	 * @var ActiveQuery - Query to fetch count of
	 * 	database table's rows for current provider
	 */
	public $countQuery = null;

	/**
	 * @var string - Order by cause
	 */
	public $orderBy = null;

	/**
	 * Construct table provider with [tableName] check
	 * @param ActiveRecord|string $activeRecord - Active record instance
	 *  or class name
	 * @param Query $fetchQuery - Query to fetch rows from
	 *  database's table
	 * @param array|null $config - Array with classes table provider
	 * 	configuration
	 * @throws Exception
	 * @see activeRecord
	 */
	public function __construct($activeRecord = null, $fetchQuery = null, $config = null) {
		if (($this->activeRecord = $activeRecord) == null) {
			throw new Exception("Table provider can't resolve [null] active record instance");
		}
		if (is_string($this->activeRecord)) {
			$this->activeRecord = new $this->activeRecord();
		}
		if ($fetchQuery == null) {
			$this->fetchQuery = $this->getFetchQuery();
		} else {
			$this->fetchQuery = $fetchQuery;
		}
		$this->countQuery = clone $this->fetchQuery;
		$this->countQuery->select("count(1) as count");
		if ($this->pagination !== false) {
			$this->pagination = $this->getPagination();
		}
		if ($config !== null) {
			foreach ($config as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	/**
	 * Override that method to return command for table widget
	 * @return ActiveQuery - Command with selection query
	 * @throws Exception
	 */
	public function getFetchQuery() {
		if ($this->fetchQuery !== null) {
			return $this->fetchQuery;
		}
		return $this->activeRecord->find()->select("*")
			->from($this->activeRecord->tableName());
	}

	/**
	 * Fetch rows from query
	 * @return array - Array with fetched data
	 */
	public function fetchData() {
		$this->fetchQuery = (new Query())->select("*")
			->from("(". $this->fetchQuery->createCommand()->getRawSql() .") as _");
		$this->countQuery = (new Query())->select("*")
			->from("(". $this->countQuery->createCommand()->getRawSql() .") as _");
		if ($this->getPagination()->optimizedMode) {
			$this->applyCriteria($this->getCriteria(), function($query) {
				/** @var $query ActiveQuery */
				$query->limit($this->getPagination()->pageLimit + 1,
					$this->getPagination()->pageLimit * $this->getPagination()->currentPage
				);
			});
		} else {
			$this->applyCriteria($this->getCriteria());
		}
		if (($row = $this->countQuery->one()) != null) {
			$count = $row["count"];
		} else {
			$count = 0;
		}
		$this->getPagination()->calculate($count);
		$this->fetchQuery->limit($this->getPagination()->getLimit())
			->offset($this->getPagination()->getOffset());
		return $this->fetchQuery->all();
	}

	/**
	 * Apply criteria to provider's query
	 * @param ActiveQuery $criteria - Database criteria
	 * @param callable $custom - Custom function for count query
	 * @return ActiveQuery - Same criteria instance
	 */
	public function applyCriteria($criteria, $custom = null) {
		if ($custom == null) {
			$queries = [
				$this->countQuery,
				$this->fetchQuery
			];
		} else {
			$queries = [
				$this->fetchQuery
			];
			$custom($this->countQuery);
		}
		foreach ($queries as $query) {
			/** @var $query ActiveQuery */
			$query->where($criteria->on, $criteria->params);
		}
		$this->fetchQuery->orderBy($criteria->orderBy)
			->orderBy($this->orderBy);
		return $criteria;
	}

	/**
	 * Get criteria ActiveQuery current provider
	 * @return ActiveQuery|null - Database criteria
	 */
	public function getCriteria() {
		if ($this->_criteria == null) {
			$this->_criteria = new ActiveQuery($this->activeRecord);
			$this->_criteria->orderBy($this->activeRecord->getTableSchema()->primaryKey);
			return $this->_criteria;
		} else {
			return $this->_criteria;
		}
	}

	/**
	 * Get pagination for current provider
	 * @return null|TablePagination - Table pagination
	 */
	public function getPagination() {
		if ($this->_pagination == null) {
			return $this->_pagination = new TablePagination();
		} else {
			return $this->_pagination;
		}
	}

	/**
	 * Get singleton database connection
	 * @return Connection - Database connection
	 */
	public function getDbConnection() {
		return \Yii::$app->getDb();
	}

	private $_criteria = null;
	private $_pagination = null;
}