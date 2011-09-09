<?php
namespace phplug\plugins\phplug_core\actions;
/**
 * Action.php
 * 
 * This File provies the Action class
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 */


/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Action implements IAction {
	
	private $js;
	
	/**
	 * 
	 * @return void
	 */
	public function setJS($js) {
		$this->js = $js;
	}
	
	public function getJS() {
		return $this->js;
	}
}