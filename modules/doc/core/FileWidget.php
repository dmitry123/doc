<?php

namespace app\modules\doc\core;

use app\core\Widget;
use app\models\doc\File;
use Exception;
use yii\base\UserException;

class FileWidget extends Widget {

    /**
     * @var string|array with supported file types, if widget
     *  assumes another, then exception will be thrown
     *
     * @internal only for internal usage, don't
     *  use that field as widget's configuration
     */
    public $allowed = "template";

	/**
	 * @var File|int file's identification number, which
	 * 	information about u'd like to load
	 */
	public $file = null;

	/**
	 * Initialize file widget class instance, it check out
	 * file field for errors and fetch it's model from database
	 *
	 * @throws Exception if something gone wrong
	 */
	public function init() {
		if (empty($this->file)) {
			throw new Exception("File's identification number mustn't be empty");
		}
		if (is_scalar($this->file) && !$this->file = File::findOne([ "id" => $this->file ])) {
			throw new Exception("Can't resolve file with identification number");
		} else if (!is_object($this->file)) {
			throw new Exception("File must be an class instance of File class or it's identification number");
		}
        if (is_array($this->allowed) && !in_array($this->file->{"file_type_id"}, $this->allowed) ||
            is_string($this->allowed) && $this->file->{"file_type_id"} != $this->allowed
        ) {
            throw new UserException("Данный тип файла не поддерживается этой операцией");
        }
	}
}