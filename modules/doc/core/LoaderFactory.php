<?php

namespace app\modules\doc\core;

class LoaderFactory {

	/**
	 * @var array - Array with supported loaders
	 */
	protected $loaders = [
		"OfficeOpenXml" => [
			"ext" => "docx"
		],
		"OpenDocumentText" => [
			"ext" => "odt"
		]
	];

	/**
	 * Get single factory instance
	 * @return LoaderFactory - Factory instance
	 */
	public static function getFactory() {
		if (self::$factory == null) {
			return self::$factory = new LoaderFactory();
		} else {
			return self::$factory;
		}
	}

	/**
	 * Create document loader with it's extension
	 * @param string $extension - Document's extension or filename
	 * @return Loader - Loader instance
	 */
	public function createWithExtension($extension) {
		$extension = preg_replace("/^.*\\./", "", $extension);
		foreach ($this->loaders as $class => &$loader) {
			if (is_array($ext = $loader["ext"])) {
				if (in_array($ext, $extension)) {
					return new $class();
				}
			} else {
				if ($ext == $extension) {
					return new $class();
				}
			}
		}
		return null;
	}

	/**
	 * Locked default constructor
	 */
	private function __construct() {
		/* Locked */
	}

	/**
	 * @var LoaderFactory - Single factory instance
	 */
	private static $factory = null;
}