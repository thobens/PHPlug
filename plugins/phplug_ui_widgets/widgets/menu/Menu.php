<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\menu;

use phplug\plugins\phplug_ui\ui\menu\IMenu;

use phplug\plugins\phplug_ui\ui as ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class Menu extends ui\Composite implements IMenu {
	
	protected $menus;
	
	protected $label;
	
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
		$this->menus = array();
	}
	
	public function addMenuEntry(IMenu $menuEntry) {
		$this->menus[$menuEntry->getId()] = $menuEntry;
	}
	
	public function getLabel() {
		return $this->label;
	}
	
	public function setLabel($label) {
		$this->label = $label;
	}
	
	public function getMenuEntries() {
		return $this->menus;
	}
}