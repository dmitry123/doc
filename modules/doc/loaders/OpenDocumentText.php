<?php

namespace app\modules\doc\loaders;

use app\modules\doc\core\ZipDocumentLoader;

class OpenDocumentText extends ZipDocumentLoader {

	/**
	 * @var string - Name of file with XML content in
	 * 	zip archive, for example - Microsoft Office OfficeOpenXml
	 * 	store it's content in 'word/document.xml' file,
	 * 	but ApacheOpenOffice store it's OpenDocumentText's content
	 * 	in 'content.xml' file
	 */
	public $content = "content.xml";

	/**
	 * @var string - File extension without dot, like
	 * 	docx, odt, and others
	 */
	public $extension = "odt";
}