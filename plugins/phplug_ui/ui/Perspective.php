<?php
namespace phplug\plugins\phplug_ui\ui;

use phplug\platform as pf,
	phplug\plugins\phplug_ui\ui\views;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class Perspective implements IPerspective {
	
	/**
	 * This location is at the very top of the window and 
	 * uses the whole width of the window.
	 * 
	 * @var string
	 */
	const HEAD	= "perspective_location_head";
	
	/**
	 * This location is at the top of the window, but not
	 * exactly at the very top but right below the HEAD location.
	 * It also uses the whole width and will be above EAST and WEST.
	 * 
	 * @var string
	 */
	const NORTH = "perspective_location_north";
	
	/**
	 * As the name says, this location will be shown on the
	 * right side of the window and will be placed below NORTH
	 * and above SOUTH.
	 * 
	 * @var string
	 */
	const EAST	= "perspective_location_east";
	
	/**
	 * This is the bottom of the window, but not at the very
	 * bottom but exactly above FOOT. This space will use the
	 * whole width and will be painted below EAST and WEST.
	 * 
	 * @var string
	 */
	const SOUTH = "perspective_location_south";
	
	/**
	 * WEST will be placed at the left of the window, right
	 * below NORTH and above SOUTH.
	 * 
	 * @var string
	 */
	const WEST	= "perspective_location_west";
	
	/**
	 * CENTER is exactly in the center of NORTH, EAST,
	 * SOUTH and WEST and will fill up all the space that is not
	 * used by the other locations.
	 * 
	 * @var string
	 */
	const CENTER = "perspective_location_center";
	
	/**
	 * This location is at the very bootom of the window.
	 * It will use the whole width of the window.
	 * 
	 * @var string
	 */
	const FOOT	= "perspective_location_foot";
	
	/**
	 * 
	 * @var array
	 */
	private $composites;

	/**
	 * 
	 * @var IPerspectiveNature
	 */
	private $nature;
	
	/**
	 * 
	 * @var string
	 */
	private $id;
	
	/**
	 * 
	 * @var array
	 */
	private $validLocations;
	
	/**
	 * The logger instance...
	 * 
	 * @var PhplugLog
	 */
	private static $log;
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IPerspective#initialize()
	 */
	public function initialize() {
		$this->composites = array();
		$this->validLocations = array(Perspective::HEAD,
									  Perspective::NORTH,
									  Perspective::EAST,
									  Perspective::SOUTH,
									  Perspective::WEST,
									  Perspective::CENTER,
									  Perspective::FOOT);
		self::$log = new pf\PhplugLog();
//		$this->template = PhplugPlatform::getActiveWorkbench()->getTemplateStore()->getTemplate("ch.thobens.templates.perspective.default");
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IPerspective#getId()
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IPerspective#setId()
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IPerspective#addView()
	 */
	public function addView(views\IViewPart $view, $location) {
		if(in_array($location,$this->validLocations)) {
			$this->composites[$location] = $view;
		} else {
			self::$log->error("Unknown location $location; View will not be added...");
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IPerspective#draw()
	 */
	public function draw() {
		$wb = pf\PhplugPlatform::getActiveWorkbench();
		$uiProcessor = $wb->getUIProcessor();
		foreach($this->composites as $location => $view) {
			$view->createViewPart(null);
			$contents = $view->getLayout()->process();
			$uiProcessor->assign($location,$contents);
		}
		return $uiProcessor->process("ch.thobens.templates.perspective.default");
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/Templateable#getTemplate()
	 */
	public function getTemplate() {
		return $this->template;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/Templateable#setTemplate()
	 */
	public function setTemplate($template) {
		$this->template = $template;
	}
}