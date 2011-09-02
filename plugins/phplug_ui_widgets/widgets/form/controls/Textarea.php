<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\form\controls;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets\form;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class Textarea extends form\Control {
	
	protected $cols;
	
	protected $rows;
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
//		$this->layout = new GridLayout();
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