<?php

namespace app\core;

interface Searchable {

	/**
	 * That method will create table provider for
	 * current table model with it's form
	 */
	public function search();
}