<?php
namespace phplug\plugins\phplug_ui_widgets_jquery\widgets\menu;

use phplug\plugins\phplug_ui\ui\layouts\ListLayout;

use phplug\plugins\phplug_ui_widgets_jquery\widgets\AccordionSection;

use phplug\plugins\phplug_ui_widgets_jquery\widgets\Accordion;

use phplug\plugins\phplug_ui\ui\layouts\GridLayout;

use phplug\plugins\phplug_ui_widgets\widgets\menu as m;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Menu extends m\Menu {
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		$layout = new GridLayout();
		$accordion = new Accordion(null);
		foreach($this->menus as $menu) {
			$section = new AccordionSection($menu->getLabel(), $this->getMenuEntryContent($menu));
			$accordion->addSection($section);
		}
		$layout->addComposite($accordion, 0,0,1,1);
		return $layout->process();
	}
	
	private function getMenuEntryContent($parent) {
		$layout = new ListLayout();
		$composites = array();
		foreach($parent->getMenuEntries() as $menu) {
			$layout->addComposite($menu, "", "");
		}
		$contents = $layout->process();
		return $contents;
	}
	
}