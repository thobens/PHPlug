<?php
namespace phplug\plugins\phplug_ui\ui;

use phplug\plugins\phplug_ui\layouts,
	phplug\plugins\phplug_ui\listener;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class Composite implements IComposite {
	
	/**
	 * 
	 * @var IEventListener
	 */
	private $eventListeners;
	
	/**
	 * 
	 * @var ILayout
	 */
	protected $layout; 
	
	/**
	 * The id of this Composite
	 * @var string
	 */
	private $id;
	
	/**
	 * 
	 * @var IComposite
	 */
	protected $parent;
	
	/**
	 * 
	 * @var int
	 */
	private $style;
	
	/**
	 * 
	 * css classes
	 * @var array
	 */
	private $classes;
	
	/**
	 * 
	 * @param $parent
	 * @param $style
	 * @return unknown_type
	 */
	public function __construct($parent, $style=0) {
		$this->parent = $parent;
		$this->style = $style;
		$this->classes = array();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IComposite#setLayout()
	 */
	public function setLayout(layouts\ILayout $layout) {
		$this->layout = $layout;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IComposite#getLayout()
	 */
	public function getLayout() {
		return $this->layout;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IComposite#addEventListener()
	 */
	public function addEventListener(listener\IEventListener $listener) {
		if(!isset($this->eventListeners)) {
			$this->eventListeners = array();
		}
		$this->eventListeners[] = $listener;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IComposite#getId()
	 */
	public function getId() {
		if(!isset($this->id)) {
			$this->id = uuid();
		}
		return $this->id;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IComposite#setId()
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * 
	 * @param string $class
	 */
	public function addClass($class) {
		$this->classes[] = $class;
	}
	
	/**
	 * 
	 * @param string $class
	 */
	public function removeClass($class) {
		foreach($this->classes as $key => $value) {
			if($class==$value) {
				unset($this->classes[$key]);
			}
		}
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getClasses() {
		return $this->classes;	
	}
}