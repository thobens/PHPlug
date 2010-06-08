<?php
namespace phplug\plugins\thobens_web_testpage\perspectives;

use phplug\plugins\phplug_ui\ui,
	phplug\plugins\thobens_web_testpage\views;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class TestPerspective extends ui\Perspective {
	
	public function createInitialLayout() {
		$this->addView(new views\TestView(),ui\Perspective::CENTER);
		$this->addView(new views\AnotherView(),ui\Perspective::EAST);
		$this->addView(new views\NonsenseView(),ui\Perspective::WEST);
	}
	
}