<?php
namespace phplug\plugins\phplug_ui\ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface UIProcessor {
	
	public function assign($var,$value);
	
	public function process();
	
}