<?php

namespace app\models;

use app\core\TableProvider;

class File extends \app\core\ActiveRecord {

	public static function tableName() {
		return "core.file";
	}

	public function getMainTableProvider($fileType) {
		return $this->createTableProvider($this->find()
			->select("*")
			->from("core.file as f")
//			->innerJoin("core.file_type as ft", "f.file_type_id = ft.id")
			->where("f.file_type_id = :file_type_id", [
				":file_type_id" => $fileType
			])
		);
	}
}