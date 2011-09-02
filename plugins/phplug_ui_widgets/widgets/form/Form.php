<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\form;

use phplug\plugins\phplug_ui\ui,
	phplug\plugins\phplug_ui\ui\layouts,
	phplug\platform as pf;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class Form extends ui\Composite {
	
	protected $action;
	
	protected $method;
	
	const GET = "get";
	
	const POST = "post";
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
		$this->layout = new layouts\GridLayout();
		$this->method = Form::GET;
	}
	
	public function addField($composite,$x,$y,$width,$height) {
		$this->layout->addComposite($composite,$x,$y,$width,$height);
	}
	
	public function getAction() {
		return $this->action;
	}
	
	public function setAction($action) {
		$this->action = $action;
	}
	
	public function getMethod() {
		return $this->method;
	}
	
	public function setMethod($method) {
		$this->method = $method;
	}
}