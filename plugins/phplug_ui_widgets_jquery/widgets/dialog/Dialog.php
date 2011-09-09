<?php
namespace phplug\plugins\phplug_ui_widgets_jquery\widgets\dialog;

use phplug\platform\PhplugPlatform;

use phplug\plugins\phplug_ui_widgets\widgets\dialog\AbstractDialog;

class Dialog extends AbstractDialog {
	
	public function draw() {
		$uip = PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("dialog", $this);
		return $uip->process("ch.thobens.templates.widgets.dialog");
	}
	
}