<?php
namespace phplug\plugins\phplug_ui_widgets_jquery\widgets\form\controls;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets\form\controls;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Textarea extends controls\Textarea {
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("name",$this->getName());
		$uip->assign("value",$this->getValue());
		$uip->assign("rows",$this->getRows());
		$uip->assign("cols", $this->getCols());
		return $uip->process("ch.thobens.templates.form.controls.textarea");
	}
	
}