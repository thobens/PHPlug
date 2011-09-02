<?php
namespace phplug\plugins\phplug_ui\ui;

class CompositePool {
	
	private $composites;
	
	private static $INSTANCE;
	
	private function __construct() {
		$this->composites = array();
	}
	
	public static function getInstance() {
		if(!isset(self::$INSTANCE)) {
			self::$INSTANCE = new self();
		}
		return self::$INSTANCE;
	}
	
	public function addComposite(IComposite $composite) {
		$this->composites[$composite->getId()] = $composite;
	}
	
	public function getComposite($id) {
		return $this->composites[$id];
	}
	
	public function getComposites() {
		return $this->composites;
	}
	
}