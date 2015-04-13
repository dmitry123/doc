<?php

namespace app\core;

use Exception;
use TablePagination;
use yii\db\ActiveQuery;
use yii\db\Connection;

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
	 *    or class name
	 * @param ActiveQuery $fetchQuery - Query to fetch rows from
	 *    database's table
	 * @param ActiveQuery $countQuery - Query to count rows from
	 *    database's table
	 * @throws Exception
	 * @see activeRecord
	 */
	public function __construct($activeRecord = null, $fetchQuery = null, $countQuery = null) {
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
		if ($countQuery == null) {
			$this->countQuery = $this->getCountQuery();
		} else {
			$this->countQuery = $countQuery;
		}
		if ($this->pagination !== false) {
			$this->pagination = $this->getPagination();
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
	 * Override that method to return count of rows in table
	 * @return ActiveQuery - Command to get count of rows
	 */
	public function getCountQuery() {
		if ($this->countQuery !== null) {
			return $this->countQuery;
		}
		return $this->activeRecord->find()->select("count(1)")
			->from($this->activeRecord->tableName());
	}

	/**
	 * Fetch rows from query
	 * @return array - Array with fetched data
	 */
	public function fetchData() {
		$this->applyCriteria($this->getCriteria());
		if (($row = $this->countQuery->createCommand()->query()) != null) {
			$count = $row["count"];
		} else {
			$count = 0;
		}
		$this->getPagination()->calculate($count);
		$this->fetchQuery->limit($this->getPagination()->getLimit(),
			$this->getPagination()->getOffset()
		);
		return $this->fetchQuery->createCommand()
			->queryAll();
	}

	/**
	 * Apply criteria to provider's query
	 * @param ActiveQuery $criteria - Database criteria
	 * @return ActiveQuery - Same criteria instance
	 */
	public function applyCriteria($criteria) {
		$queries = [
			$this->countQuery,
			$this->fetchQuery
		];
		foreach ($queries as $query) {
			/** @var $query ActiveQuery */
			$query->where($criteria->on, $criteria->params);
		}
		if (!empty($criteria->orderBy)) {
			$this->fetchQuery->addOrderBy($criteria->orderBy);
		}
		if (!empty($this->orderBy)) {
			$this->fetchQuery->addOrderBy($this->orderBy);
		}
		return $criteria;
	}

	/**
	 * Get criteria for current provider
	 * @return ActiveQuery|null - Database criteria
	 */
	public function getCriteria() {
		if ($this->_criteria == null) {
			return $this->_criteria = $this->activeRecord->find()->orderBy(
				$this->activeRecord->getTableSchema()->primaryKey
			);
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
		return \Yii::$app->db;
	}

	private $_criteria = null;
	private $_pagination = null;
}