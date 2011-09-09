<?php
namespace phplug\plugins\phplug_ui\ui\listener;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
use phplug\plugins\phplug_core\actions\IAction;

class EventListener implements IEventListener {
	
	private $event;
	
	private $actions;
	
	public function __construct() {
		$this->actions = array();
	}
	
	public function setEvent($event) {
		$this->event = event;
	}
	
	public function getEvent() {
		return $this->event;
	}
	
	public function addAction(IAction $action) {
		$this->actions[] = $action;
	}
	
	public function getActions() {
		return $this->actions;
	}
	
}
