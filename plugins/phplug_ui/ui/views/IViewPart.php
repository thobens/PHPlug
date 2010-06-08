<?php
namespace phplug\plugins\phplug_ui\ui\views;

use phplug\plugins\phplug_ui\ui\layouts;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IViewPart {
	
	/**
	 * 
	 * @param $parent
	 * @return unknown_type
	 */
	public function createViewPart($parent);
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function dispose();
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function init();
	
	/**
	 * 
	 * @return ILayout
	 */
	public function getLayout();
	
	/**
	 * 
	 * @param $layout
	 * @return void
	 */
	public function setLayout(layouts\ILayout $layout);
}