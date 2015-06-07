<?php

namespace app\widgets;

use app\core\Widget;
use Exception;
use yii\helpers\Html;
use yii\web\AssetManager;

class ControlMenu extends Widget {

	/**
	 * Disable control elements, has no attributes, so array
	 * may be null or empty (same effect)
	 */
	const MODE_NONE = 0;

	/**
	 * Control elements displays as <a> tag with label, attributes:
	 *  + label - displayable <a> text
	 *  + [icon] - name of glyphicon class
	 *  + ... - other HTML attributes (for <a>)
	 * Warning: it automatically removes all classes which starts
	 *  with 'btn', cuz it helps to use it button and icon mode together
	 * @see buttonRegexp
	 */
	const MODE_TEXT = 1;

	/**
	 * Control elements displays as glyphicons with tooltips, attributes:
	 *  + [label] - text for tooltip
	 *  + icon - class for glyphicon
	 *  + ... - other HTML attributes (for <span>)
	 * Warning: it automatically removes all classes which starts
	 *  with 'btn', cuz it helps to use it button and icon mode together
	 * @see buttonRegexp
	 */
	const MODE_ICON = 2;

	/**
	 * Control elements displays as buttons, attributes:
	 *  + label - button text
	 *  + [icon] - glyphicon before button's text
	 *  + ... - other HTML attributes
	 */
	const MODE_BUTTON = 3;

	/**
	 * Control elements displays as dropdown list, attributes:
	 *  + label - menu item label
	 *  + [parent] - HTML attributes for parent node <li>
	 *  + [icon] - glyphicon before item's text
	 *  + ... - other HTML attributes
	 */
	const MODE_MENU = 4;

	/**
	 * Control elements displays as dropdown list, with sub-items:
	 *  + label - menu items label
	 *  + [items] - array with sub-items
	 *  + [parent] - HTML attributes for parent node <ul>
	 *  + [icon] - glyphicon before items' text
	 *  + ... - other HTML attributes
	 */
	const MODE_LIST = 5;

	/**
	 * Control elements displays as buttons wrapped by
	 * justified group, attributes:
	 *  + label - button text
	 *  + [icon] - glyphicon before button's text
	 *  + ... - other HTML attributes
	 */
	const MODE_GROUP = 6;

	/**
	 * @var int - How to display control elements, set it
	 * 	to CONTROL_MODE_NONE to disable control elements
	 */
	public $mode = self::MODE_ICON;

	/**
	 * @var array - Array with control elements, it's attributes depends on
	 * 	control display mode. You should always use [icon] and [label] attributes
	 * 	cuz every control mode must support that attributes. Control parameters
	 * 	is HTML attributes that moves to it's tag (tag name depends on control
	 * 	display mode).
	 * @see controlMode
	 */
	public $controls = null;

	/**
	 * @var string - Regular expression to remove button classes from
	 * 	icon and text elements
	 */
	public $buttonRegexp = '/btn\\-*[a-z]* /';

	/**
	 * @var string - Name of special class which automatically
	 * 	adds to every control element
	 */
	public $special = 'control-menu-button';

	/**
	 * @var string with name of class for default menu icon, works
	 * 	only for [MODE_MENU] renders mode
	 */
	public $menuIcon = 'glyphicon glyphicon-list';

	/**
	 * @var string placement of tooltip message, only
	 * 	for [MODE_ICON] renders mode
	 */
	public $placement = 'left';

	/**
	 * Run widget to render control elements
	 */
	public function run() {
		if (!empty($this->controls)) {
			$this->renderControls();
		}
	}

	public function prepareControl($key, array& $attributes) {
		if (!isset($attributes['class'])) {
			$attributes['class'] = ' '.$this->special.' '.$key;
		} else {
			$attributes['class'] .= ' '.$this->special.' '.$key;
		}
		if (isset($attributes['label'])) {
			$label = $attributes['label'];
		} else {
			$label = null;
		}
		if (isset($attributes['icon'])) {
			$icon = $attributes['icon'];
		} else {
			$icon = null;
		}
		if (isset($attributes['parent'])) {
			$parent = $attributes['parent'];
		} else {
			$parent = [];
		}
		if (isset($attributes['items'])) {
			$items = $attributes['items'];
		} else {
			$items = [];
		}
		unset($attributes['label']);
		unset($attributes['icon']);
		unset($attributes['parent']);
		unset($attributes['items']);
		return [
			'label' => $label,
			'icon' => $icon,
			'parent' => $parent,
			'items' => $items
		];
	}

	public function renderTextControls() {
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required['label'])) {
				throw new Exception('Panel\'s controls mode [CONTROL_MODE_BUTTON] requires [label] attribute');
			} else {
				$label = $required['label'];
			}
			if (!empty($required['icon'])) {
				$label = Html::tag('span', '', [
						'class' => $required['icon']
					]) .'&nbsp;&nbsp;'. $label;
			}
			$options['class'] = preg_replace($this->buttonRegexp, '', $options['class']);
			print Html::tag('a', $label, $options);
		}
	}

	public function renderIconControls() {
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required['icon'])) {
				throw new Exception('Panel\'s controls mode [CONTROL_MODE_ICON] requires [icon] attribute');
			} else {
				$options['class'] .= ' '.$required['icon'];
			}
			if (!empty($required['label'])) {
				$options += [
					'onmouseenter' => '$(this).tooltip("show")',
					'title' => $required['label'],
					'data-placement' => $this->placement
				];
			}
			$options['class'] = preg_replace($this->buttonRegexp, '', $options['class']);
			print Html::tag('span', '', $options);
		}
	}

	public function renderButtonControls() {
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required['label'])) {
				$label = '';
			} else {
				$label = $required['label'];
			}
			if (!empty($required['icon'])) {
				$label = Html::tag('span', '', [
					'class' => $required['icon']
				]) .'&nbsp;&nbsp;'. $label;
			}
			print Html::tag('button', $label, $options);
		}
	}

	public function renderGroupControls() {
		print Html::beginTag('div', [
			'class' => 'btn-group btn-group-justified'
		]);
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required['label'])) {
				$label = '';
			} else {
				$label = $required['label'];
			}
			if (!empty($required['icon'])) {
				$label = Html::tag('span', '', [
						'class' => $required['icon']
					]) .'&nbsp;&nbsp;'. $label;
			}
			print Html::tag('div', Html::tag('button', $label, $options), [
				'class' => 'btn-group'
			]);
		}
		print Html::endTag('div');
	}

	public function renderMenuControls() {
		print Html::beginTag('div', [
			'class' => 'dropdown',
			'style' => 'margin-left: -158px',
		]);
		print Html::tag('div', Html::tag('span', '', [
			'class' => $this->menuIcon,
            'style' => 'margin-right: 10px'
		]), [
			'href' => 'javascript:void(0)',
			'class' => 'dropdown-toggle',
			'data-toggle' => 'dropdown',
			'aria-haspopup' => 'true',
			'role' => 'button',
			'aria-expanded' => 'false',
			'style' => 'cursor: pointer',
		]);
		print Html::beginTag('ul', [
			'class' => 'dropdown-menu',
			'role' => 'menu'
		]);
		foreach ($this->controls as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (empty($required['label'])) {
				throw new Exception('Panel\'s controls mode [CONTROL_MODE_MENU] requires [label] attribute');
			} else {
				$label = $required['label'];
			}
			if (!empty($required['icon'])) {
				$label = Html::tag('span', '', [
						'class' => $required['icon'],
					]) .'&nbsp;&nbsp;'. $label;
			}
			$options['class'] = preg_replace($this->buttonRegexp, '', $options['class']);
			if (isset($required['parent']['class'])) {
				$required['parent']['class'] .= ' text-left';
			} else {
				$required['parent']['class'] = 'text-left';
			}
			print Html::tag('li', Html::tag('a', $label, [
					'role' => 'menuitem',
					'tagindex' => '-1'
				] + $options), $required['parent'] + [
					'role' => 'presentation'
				]
			);
		}
		print Html::endTag('ul');
		print Html::endTag('div');
	}

	public function renderListControls($items = null) {
		print Html::beginTag('ul', [
			'class' => 'btn-group btn-group-justified',
			'role' => 'group'
		]);
		if ($items === null) {
			$items = $this->controls;
		}
		foreach ($items as $class => $options) {
			$required = $this->prepareControl($class, $options);
			if (!empty($required['items'])) {
				$options['class'] .= ' dropdown';
			}
			if (isset($options['class'])) {
				$options['class'] .= ' btn btn-lg btn-default';
			} else {
				$options['class'] = 'btn btn-lg btn-default';
			}
			if (isset($required['parent']['class'])) {
				$required['parent']['class'] .= ' btn-group';
			} else {
				$required['parent']['class'] = ' btn-group';
			}
			print Html::beginTag('li', $required['parent']);
			print Html::tag('a', $required['label'], $options + [
				'type' => 'button'
			]);
			print Html::endTag('li');
		}
		print Html::endTag('ul');
	}

	/**
	 * Render menu with control elements
	 */
	public function renderControls() {
		switch ($this->mode) {
			case self::MODE_TEXT:
				$this->renderTextControls();
				break;
			case self::MODE_ICON:
				$this->renderIconControls();
				break;
			case self::MODE_BUTTON:
				$this->renderButtonControls();
				break;
			case self::MODE_GROUP:
				$this->renderGroupControls();
				break;
			case self::MODE_MENU:
				$this->renderMenuControls();
				break;
			case self::MODE_LIST:
				$this->renderListControls();
				break;
		}
	}
}