<?php

namespace app\core;

use yii\helpers\Html;

class ActiveField extends \yii\widgets\ActiveField {

	public $options = [];

	/**
	 * Renders the whole field.
	 * This method will generate the label, error tag, input tag and hint tag (if any), and
	 * assemble them into HTML according to [[template]].
	 * @param string|callable $content the content within the field container.
	 * If null (not set), the default methods will be called to generate the label, error tag and input tag,
	 * and use them as the content.
	 * If a callable, it will be called to generate the content. The signature of the callable should be:
	 *
	 * ~~~
	 * function ($field) {
	 *     return $html;
	 * }
	 * ~~~
	 *
	 * @return string the rendering result
	 */
	public function render($content = null) {
		if ($content === null) {
			if (!isset($this->parts['{input}'])) {
				$this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $this->inputOptions);
			}
			if (!isset($this->parts['{label}'])) {
				$this->parts['{label}'] = Html::activeLabel($this->model, $this->attribute, $this->labelOptions);
			}
			if (!isset($this->parts['{error}'])) {
				$this->parts['{error}'] = Html::error($this->model, $this->attribute, $this->errorOptions);
			}
			if (!isset($this->parts['{hint}'])) {
				$this->parts['{hint}'] = '';
			}
			$content = strtr($this->template, $this->parts);
		} elseif (!is_string($content)) {
			$content = call_user_func($content, $this);
		}
		return $content;
	}
}