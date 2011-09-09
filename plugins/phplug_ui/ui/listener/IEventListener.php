<?php
namespace phplug\plugins\phplug_ui\ui\listener;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
use phplug\plugins\phplug_core\actions\IAction;

interface IEventListener extends IListener {
	
	public function setEvent($event);
	
	public function getEvent();
	
	public function addAction(IAction $action);
	
	public function getActions();
	
}
