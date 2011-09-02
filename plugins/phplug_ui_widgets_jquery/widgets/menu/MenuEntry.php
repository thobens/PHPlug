<?php
namespace phplug\plugins\phplug_ui_widgets_jquery\widgets\menu;

use phplug\plugins\phplug_ui\ui\layouts\ListLayout;

use phplug\plugins\phplug_ui_widgets\widgets\menu as m;

use phplug\plugins\phplug_ui\ui as ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class MenuEntry extends m\MenuEntry {
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		return $this->getLabel();
	}
}