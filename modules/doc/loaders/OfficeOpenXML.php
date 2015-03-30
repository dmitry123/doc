<?php

namespace app\modules\doc\loaders;

use app\modules\doc\core\ZipLoader;

class OfficeOpenXml extends ZipLoader {

	/**
	 * @var string - Name of file with XML content in
	 * 	zip archive, for example - Microsoft Office Docx
	 * 	store it's content in 'word/document.xml' file,
	 * 	but ApacheOpenOffice store it's OpenDocumentText's content
	 * 	in 'content.xml' file
	 */
	public $content = "word/document.xml";

	/**
	 * @var string - File extension without dot, like
	 * 	OfficeOpenXml, OpenDocumentText, and others
	 */
	public $extension = "docx";
}