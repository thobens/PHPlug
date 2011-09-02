<?php
namespace phplug\plugins\phplug_ui\ui\menu;

use phplug\plugins\phplug_ui\ui\IComposite;

interface IMenu extends IComposite{
	
	public function addMenuEntry(IMenu $menu);
	
	public function getLabel();
	
	public function setLabel($label);
	
	public function getMenuEntries();
	
}