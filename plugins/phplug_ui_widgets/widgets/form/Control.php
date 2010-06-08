<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\form;

use phplug\plugins\phplug_ui\ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class Control extends ui\Composite {
	
	/**
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * 
	 * @var string
	 */
	protected $value;
	
	/**
	 * 
	 * @param $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * 
	 * @param $value
	 * @return void
	 */
	public function setValue($value) {
		$this->value = $value;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}
}