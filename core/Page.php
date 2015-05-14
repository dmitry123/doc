<?php

namespace app\core;

use yii\base\Object;

abstract class Page extends Object {

	public $assets = [];

	public $js = [];

	public $css = [];

	public abstract function render();
}