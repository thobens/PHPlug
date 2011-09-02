<?php
namespace phplug\plugins\phplug_core\actions;
/**
 * Action.class.php
 * 
 * This File provies the Action Interface
 * 
 * date: 2010-03-12
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
interface IAction {
	
	/**
	 * 
	 * @return void
	 */
	public function run();
}