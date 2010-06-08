<?php
namespace phplug\plugins\phplug_ui_widgets\widgets;

use phplug\platform as pf,
	phplug\plugins\phplug_ui\ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Text extends ui\Composite {
	
	/**
	 * 
	 * @var string
	 */
	private $text;
	
	public function __construct($parent,$style=0,$text="") {
		parent::__construct($parent,$style);
		$this->text = $text;
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("content",$this->getText());
		$contents = $uip->process("ch.thobens.templates.container");
		return $contents;
	}
	
	/**
	 * 
	 * @param $text
	 * @return unknown_type
	 */
	public function setText($text) {
		$this->text = $text;
	}
	
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getText() {
		return $this->text;
	}
	
}