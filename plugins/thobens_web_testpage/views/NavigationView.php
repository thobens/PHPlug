<?php
namespace phplug\plugins\thobens_web_testpage\views;

use phplug\plugins\phplug_ui\UIPlugin;

use phplug\platform\PhplugPlatform;

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
		
		$menu = PhplugPlatform::getPluginById(UIPlugin::PLUGIN_ID)->getMenuById("ch.thobens.testpage.mainNav");
		$layout->addComposite($menu, 0,0,1,1);
		
		$this->setLayout($layout);
	}
}
?>