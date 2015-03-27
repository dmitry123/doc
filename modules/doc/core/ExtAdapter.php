<?php

namespace app\modules\doc\core;

class ExtAdapter extends DocumentLoader {

	/**
	 * Override that method to open document and store
	 * it's handle in self class for next actions
	 * @param string $filename - Name of document to load
	 * @return DocumentLoader - Self instance
	 * @throws \Exception
	 */
	public function open($filename) {
		if (($this->loader = LoaderFactory::getFactory()->createWithExtension($filename)) == null) {
			throw new \Exception("Can't resolve loader for that file \"$filename\"");
		} else {
			$this->loader->open($filename);
		}
		return $this;
	}

	/**
	 * Load XML content from document by it's index name
	 * @return string - Document content in XML format
	 * @throws \Exception
	 */
	public function getContent() {
		if ($this->loader == null) {
			throw new \Exception("Document hasn't been opened");
		} else {
			return $this->loader->getContent();
		}
	}

	/**
	 * Override that file to close session with local file
	 * @return DocumentLoader - Self instance
	 * @throws \Exception
	 */
	public function close() {
		if ($this->loader == null) {
			throw new \Exception("Document hasn't been opened");
		} else {
			return $this->loader->close();
		}
	}

	/**
	 * @var DocumentLoader - Loader instance
	 */
	private $loader = null;
}