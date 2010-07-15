<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\form\controls;

use phplug\platform as pf,
	phplug\plugins\phplug_ui_widgets\widgets\form;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class Select extends form\Control {
	
	protected $options;

	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
		$this->options = array();
	}
	
	public function getOptions() {
		return $this->options;
	}
	
	public function addOption(SelectOption $option) {
		$this->options[] = $option;
	}
	
	public function setOptions($options) {
		$this->options = $options;
	}
}

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class SelectOption {
	
	public $name;
	
	public $value;
	
	public function __construct($name,$value) {
		$this->name = $name;
		$this->value = $value;	
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setValue($value) {
		$this->value = $value;
	}
	
	public function getValue() {
		return $this->value;
	}
	
}