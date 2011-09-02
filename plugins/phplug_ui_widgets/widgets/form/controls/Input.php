<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\form\controls;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets\form;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class Input extends form\Control {
	
	protected $type;
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function getType() {
		return $this->type;
	}
	
}