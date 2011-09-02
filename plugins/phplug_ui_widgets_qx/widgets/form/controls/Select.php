<?php
namespace phplug\plugins\phplug_ui_widgets_qx\widgets\form\controls;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets\form\controls;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Select extends controls\Select {
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("name",$this->getName());
		$uip->assign("value",$this->getValue());
		$uip->assign("options",$this->getOptions());
		return $uip->process("ch.thobens.templates.form.controls.select");
	}
	
}
