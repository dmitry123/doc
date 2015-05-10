<?php

namespace app\core;

interface Factory {

	/**
	 * Produce instance of some component via
	 * your factory singleton instance
	 *
	 * @param $id int|string identification number
	 *    of your object, which will be produced
	 *
	 * @param $params array with class parameters
	 * 	which copies to itself
	 *
	 * @return mixed instance of something
	 */
	public function create($id, $params = []);
}