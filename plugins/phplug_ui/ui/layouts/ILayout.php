<?php
namespace phplug\plugins\phplug_ui\ui\layouts;

use phplug\platform as pf;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface ILayout extends pf\Templateable {
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function process();
	
}