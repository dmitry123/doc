<?php

namespace app\widgets;

use app\core\Widget;

class SideMenu extends Widget {

	/**
	 * Executes the widget.
	 * This method is called by {@link CBaseController::endWidget}.
	 */
	public function run() {
		print SideNav::widget([
			"type" => SideNav::TYPE_DEFAULT,
			"heading" => "Options",
			"items" => [
				[
					"url" => "#",
					"label" => "123",
					"icon" => "home",
					"items" => [
						[
							"url" => "#",
							"label" => "123",
							"icon" => "home"
						], [
							"url" => "#",
							"label" => "321",
							"icon" => "home"
						]
					]
				], [
					"url" => "#",
					"label" => "321",
					"icon" => "home"
				]
			]
		]);
	}
}