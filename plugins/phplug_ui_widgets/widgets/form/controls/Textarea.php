<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\form\controls;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets\form;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Textarea extends form\Control {
	
	private $cols;
	
	private $rows;
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
//		$this->layout = new GridLayout();
	}
	
	public function draw() {
		$uip = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$uip->assign("name",$this->getName());
		$uip->assign("value",$this->getValue());
		$uip->assign("rows",$this->getRows());
		$uip->assign("cols", $this->getCols());
		return $uip->process("ch.thobens.templates.form.controls.textarea");
	}
	
	public function setCols($cols) {
		$this->cols = $cols;
	}
	
	public function getCols() {
		return $this->cols;
	}
	
	public function setRows($rows) {
		$this->rows = $rows;
	}
	
	public function getRows() {
		return $this->rows;
	}
	
}