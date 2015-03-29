<?php

namespace app\modules\doc\core;

class FileUploader {

	/**
	 * Locked constructor
	 */
	private function __construct() {
		/* Locked */
	}

	public function upload(array $files) {

	}

	/**
	 * Get single file uploader instance
	 * @return FileUploader - Instance of file uploader
	 */
	public static function getUploader() {
		if (self::$uploader == null) {
			return self::$uploader = new FileUploader();
		} else {
			return self::$uploader;
		}
	}

	/**
	 * @var FileUploader - single file uploader instance
	 */
	private static $uploader = null;
}