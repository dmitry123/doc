<?php

namespace app\modules\doc\core;

abstract class Loader {

	/**
	 * Construct document with filename, it will load document
	 * @param string $filename - Path to document or null
	 * @throws \Exception
	 */
	public function __construct($filename = null) {
		if ($filename != null) {
			$this->open($filename);
		}
	}

	/**
	 * Override that method to open document and store
	 * it's handle in self class for next actions
	 * @param string $filename - Name of document to load
	 * @return Loader - Self instance
	 */
	public abstract function open($filename);

	/**
	 * Load XML content from document by it's index name
	 * @return string - Document content in XML format
	 * @throws \Exception
	 */
	public abstract function getContent();

	/**
	 * Override that file to close session with local file
	 * @return Loader - Self instance
	 */
	public abstract function close();
}