<?php
namespace phplug\plugins\phplug_ui\ui;

use phplug\platform as pf,
	phplug\plugins\phplug_ui\ui\views;

/**
 * IViewPar
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPerspective extends pf\Templateable {
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function createInitialLayout();
	
	/**
	 * 
	 * @param $view
	 * @param $location
	 * @return void
	 */
	public function addView(views\IViewPart $view, $location);
	
	/**
	 * 
	 * @return void
	 */
	public function initialize();
	
	/**
	 * 
	 * @return string
	 */
	public function getId();
	
	/**
	 * 
	 * @return void
	 */
	public function setId($id);
	
	/**
	 * 
	 * @return void
	 */
	public function draw();
}