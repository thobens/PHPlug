<?php
namespace phplug\plugins\phplug_ui_widgets_jquery\widgets\form\controls;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets\form\controls;

/**
 * A Basic Input Field, painted with qooxdoo.
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Input extends controls\Input {
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("id",$this->getId());
		$uip->assign("name",$this->getName());
		$uip->assign("value",$this->getValue());
		$uip->assign("type",$this->getType());
		//TODO should be handled on a lower level
		$uip->assign("events", $this->eventListeners);
		return $uip->process("ch.thobens.templates.form.controls.input");
	}
	
}