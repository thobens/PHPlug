<?php
namespace phplug\plugins\phplug_ajax_support\services;

use phplug\plugins\phplug_core\annotations\ReflectionAnnotatedClass;

use phplug\plugins\phplug_core\contexts\Contexts;

use phplug\platform\PhplugLog;

class ServiceRegistry {
	
	private static $INSTANCE;
	
	private static $log;

	private $services;
	
	private function __construct() {
		$this->services = array();
		self::$log = new PhplugLog();
	}
	
	public static function instance() {
		if(!isset(self::$INSTANCE)) {
			self::$INSTANCE = new self();
		}
		return self::$INSTANCE;
	}
	
	public function registerService($name, $service, $context = Contexts::SESSION_CONTEXT) {
		self::$log->info("Registering service for ".$name);
		$rClass = new ReflectionAnnotatedClass($service);
		$this->services[$name] = $rClass->newInstance();
	}
	
	public function getService($name) {
		return $this->services[$name];
	}
	
	public function persistServices() {
		$phplug_cfg = PhplugPlatform::getConfig();
		$dbh = sqlite_open($this->contextDb, 0666, $error) or die($error);
		foreach($this->services as $interface => $implementations) {
			foreach($implementations as $implementation) {
			}
		}
		sqlite_close($dbh);
	}
	
}