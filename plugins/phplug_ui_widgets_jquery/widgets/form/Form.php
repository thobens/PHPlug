<?php
namespace phplug\plugins\phplug_ui_widgets_jquery\widgets\form;

use phplug\plugins\phplug_ui_widgets\widgets\form as f,
	phplug\platform as pf;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Form extends f\Form {
	
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("method", $this->getMethod());
		$uip->assign("action", $this->getAction());
		$uip->assign("content",$this->layout->process());
		return $uip->process("ch.thobens.templates.form.form");
	}
	
}