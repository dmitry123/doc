<?php

namespace app\components;

interface Searchable {

	/**
	 * That method will create table provider for
	 * current table model with it's form
	 */
	public function search();
}