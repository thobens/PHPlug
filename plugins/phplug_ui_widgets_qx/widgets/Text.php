<?php
namespace phplug\plugins\phplug_ui_widgets_qx\widgets;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Text extends widgets\Text {
	
	public function __construct($parent,$style=0,$text="") {
		parent::__construct($parent,$style,$text);
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("content",$this->getText());
		$contents = $uip->process("ch.thobens.templates.container");
		return $contents;
	}
	
}