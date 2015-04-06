<?php

namespace app\core;

use yii\base\Object;
use yii\db\Query;

class PostgreSQL extends Object {

	/**
	 * Fetch list with table column names and types
	 * @param string $tableName - Name of table to fetch
	 * @param string $tableSchema - Name of table's schema
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function findColumnNamesAndTypes($tableName, $tableSchema = "public") {
		$rows = (new Query())->select("column_name as name, data_type as type")
			->from("information_schema.columns")
			->where("table_schema = :table_schema AND table_name = :table_name", [
				":table_schema" => $tableSchema,
				":table_name" => $tableName
			])->all();
		return $rows;
	}
}