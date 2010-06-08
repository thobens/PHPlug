<?php
namespace phplug\plugins\phplug_ui\ui;

use phplug\plugins\phplug_ui\layouts,
	phplug\plugins\phplug_ui\listener;


/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IComposite {
	/**
	 * Draws the composite
	 * @return void
	 */
	public function draw();
	
	/**
	 * 
	 * @param $layout
	 * @return void
	 */
	public function setLayout(layouts\ILayout $layout);
	
	/**
	 * 
	 * @return ILayout
	 */
	public function getLayout();
	
	/**
	 * 
	 * @return void
	 */
	public function addEventListener(listener\IEventListener $listener);
	
	/**
	 * 
	 * @return string
	 */
	public function getId();
	
	/**
	 * 
	 * @param $id
	 * @return void
	 */
	public function setId($id);
	
}