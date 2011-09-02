<?php
namespace phplug\plugins\phplug_ui_widgets_jquery\widgets;

use phplug\plugins\phplug_ui\ui\Composite;

use phplug\platform as pf;

/**
 * A Basic Input Field, painted with qooxdoo.
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Accordion extends Composite {
	
	private $sections;
	
	public function __construct($parent,$style=0) {
		$this->sections = array();
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("id", $this->getId());
		$uip->assign("sections", $this->sections);
		return $uip->process("ch.thobens.templates.accordion");
	}
	
	public function addSection(AccordionSection $section) {
		$this->sections[] = $section;
	}
	
}