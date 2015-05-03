<?php

namespace app\core;

interface Factory {

	/**
	 * Produce instance of some component via
	 * your factory singleton instance
	 *
	 * @param $module string name of module for
	 *    current component
	 *
	 * @param $id int|string identification number
	 *    of your object, which will be produced
	 *
	 * @param $params array with class parameters
	 * 	which copies to itself
	 *
	 * @return mixed instance of something
	 */
	public function create($module, $id, $params = []);
}