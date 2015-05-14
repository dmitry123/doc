<?php

namespace app\core;

interface FormControl {

	/**
	 * Override that method to return with controls, where
	 * key is name of class and body is array with configuration
	 *  + [class] - button class (default 'btn btn-primary')
	 *  + [tag] - button html tag (default 'button')
	 *  + [text] - displayable text (default nothing, only for button tag)
	 *  + [options] - html option configurations
	 * @return array - Array with controls
	 */
	public function getControls();
}