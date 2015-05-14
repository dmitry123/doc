<?php

namespace app\components;

interface FileProtocol {

	/**
	 * Override that method to return table provider
	 * for database model which provides actions with
	 * files
	 *
	 * @return TableProvider - Instance of table provider
	 * 	with custom [fetchQuery] and [countQuery]
	 */
	public function getFileTableProvider();
}