<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\form\controls;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets\form;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Input extends form\Control {
	
	private $type;
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("name",$this->getName());
		$uip->assign("value",$this->getValue());
		$uip->assign("type",$this->getType());
		return $uip->process("ch.thobens.templates.form.controls.input");
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function getType() {
		return $this->type;
	}
	
}