<?php

namespace app\core;

use yii\base\Object;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class PostgreSQL extends Object {

	/**
	 * Fetch list with table column names and types
	 * @param string $tableName - Name of table to fetch
	 * @param string $tableSchema - Name of table's schema
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public static function findColumnNamesAndTypes($tableName, $tableSchema = "core") {
		$rows = (new Query())->select("column_name as name, data_type as type")
			->from("information_schema.columns")
			->where("table_schema = :table_schema AND table_name = :table_name", [
				":table_schema" => $tableSchema,
				":table_name" => $tableName
			])->all();
		return $rows;
	}

    public static function findTables($tables = null) {
        $query = (new Query())->select("table_schema AS schema, table_name AS name, table_type AS type")
            ->from("information_schema.tables")
            ->where("table_schema in (". implode(",", [ "'core'", "'doc'" ]) .")");
        if ($tables != null) {
            foreach ($tables as &$t) {
                $t = preg_replace('/([\w\d]+\.[\w\d]+)/i', "'$1'", $t);
            }
            $query->andWhere("concat(table_schema, '.', table_name) in (". implode(",", $tables) .")");
        }
        return $query->all();
    }

    public static function findLocalizedTables($tables = null) {
        $rows = static::findTables($tables);
        foreach ($rows as &$row) {
            $row["localize"] = TableLocalization::localize("{$row["schema"]}.{$row["name"]}");
        }
        return $rows;
    }

    public static function findOrderedAndHashed($tables = null) {
        $tables = PostgreSQL::findLocalizedTables($tables);
        $array = [];
        foreach ($tables as $key => $table) {
            $full = $table["schema"].".".$table["name"];
            $hash = md5($full);
            $array[$hash] = $table + [
                    "hash" => $hash,
                    "full" => $full
                ];
        }
        return $array;
    }

    public static function matchTable($hash) {
        if (static::$_hashed == null) {
            static::$_hashed = static::findOrderedAndHashed();
        }
        if (isset(static::$_hashed[$hash])) {
            return static::$_hashed[$hash];
        } else {
            return null;
        }
    }

    private static $_hashed = null;
}