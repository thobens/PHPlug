<?php
namespace phplug\plugins\phplug_core\annotations;

use phplug\platform\PhplugLog;

class AnnotationMap {
	
	private $annotations;
	
	private static $log;
	
	private static $INSTANCE;
	
	private function __construct() {
		$this->annotations = array();
		self::$log = new PhplugLog();
	}
	
	public static function getInstance() {
		if(!isset(self::$INSTANCE)) {
			self::$INSTANCE = new self();
		}
		return self::$INSTANCE;
	}
	
	public function register($name, $class) {
		if(isset($this->annotations[$name])) {
			self::$log->warn("Annotation with name $name will not be registered because it's already registered.");
			return;
		}
		$this->annotations[$name] = $class;
		self::$log->debug("registered annotation with name $name and class $class");
	}
	
	public function getClass($name) {
		return $this->annotations[$name];
	}
	
}