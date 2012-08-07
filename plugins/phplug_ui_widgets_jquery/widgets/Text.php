<?php
namespace phplug\plugins\phplug_ui_widgets_jquery\widgets;

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
		$uip->assign("id", $this->getId());
		$uip->assign("classes", implode(" ", $this->classes));
		$contents = $uip->process("ch.thobens.templates.container");
		return $contents;
	}
	
}