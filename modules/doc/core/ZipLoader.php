<?php

namespace app\modules\doc\core;

abstract class ZipDocumentLoader extends DocumentLoader {

	/**
	 * @var string - Name of file with XML content in
	 * 	zip archive, for example - Microsoft Office DocX
	 * 	store it's content in 'word/document.xml' file,
	 * 	but ApacheOpenOffice store it's Odt's content
	 * 	in 'content.xml' file
	 */
	public $content = null;

	/**
	 * Override that method to open document and store
	 * it's handle in self class for next actions
	 * @param string $filename - Name of document to load
	 * @return ZipDocumentLoader
	 * @throws \Exception
	 */
	public function open($filename) {
		if ($this->zip !== null) {
			$this->close();
		}
		$this->zip = new \ZipArchive();
		if ($this->zip->open($filename) !== true) {
			throw new \Exception("Can't open zip archive \"{$this->zip->getStatusString()}\"");
		}
		return $this;
	}

	/**
	 * Load XML content from document by it's index name
	 * @return string - Document content in XML format
	 * @throws \Exception
	 */
	public function getContent() {
		if (empty($this->content)) {
			throw new \Exception("Document content filename can't be empty and mustn't be null");
		}
		if (($index = $this->zip->locateName($this->content)) === false) {
			throw new \Exception("Can't resolve index of \"{$this->content}\" file");
		}
		return $this->zip->getFromIndex($index);
	}

	/**
	 * Override that file to close session with local file
	 * @return ZipDocumentLoader - Self instance
	 * @throws \Exception
	 */
	public function close() {
		if ($this->zip == null) {
			throw new \Exception("Document hasn't been loaded");
		}
		if ($this->zip->close() === false) {
			throw new \Exception("Can't close archive file");
		}
		return $this;
	}

	/**
	 * Get zip archive instance
	 * @return \ZipArchive - Zip archive instance
	 */
	public function getZip() {
		return $this->zip;
	}

	/**
	 * @var \ZipArchive - ZipArchive instance
	 */
	private $zip = null;
}