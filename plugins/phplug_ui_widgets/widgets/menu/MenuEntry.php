<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\menu;

use phplug\plugins\phplug_ui\ui\menu\IMenu;

use phplug\plugins\phplug_ui\ui as ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class MenuEntry extends Menu {
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}

}