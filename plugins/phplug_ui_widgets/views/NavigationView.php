<?php
namespace phplug\plugins\phplug_ui_widgets\views;

use phplug\plugins\phplug_ui_widgets_jquery\widgets\AccordionSection;

use phplug\plugins\phplug_ui\ui\layouts\GridLayout;

use phplug\plugins\phplug_ui\ui\views\ViewPart;

use phplug\plugins\thobens_web_testpage\test\TestAnnotationField;

use phplug\plugins\phplug_ui_widgets_jquery\widgets\Accordion;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class NavigationView extends ViewPart {
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/views/IViewPart#createViewPart()
	 */
	public function createViewPart($parent) {
		$layout = new GridLayout();
		
		$accordion = new Accordion(null);
		$accordion->setId("navi");
		$section = new AccordionSection("Bla blubb", "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.");
		$accordion->addSection($section);
		$section = new AccordionSection("Hahhahaa", "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.");
		$accordion->addSection($section);
		$section = new AccordionSection("Bssssss", "Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.");
		$accordion->addSection($section);
		$layout->addComposite($accordion,0,0,1,1);
		
		$this->setLayout($layout);
	}
}
?>