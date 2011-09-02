<?php
namespace phplug\plugins\phplug_ajax_support;

use phplug\plugins\phplug_core\CorePlugin;

use phplug\platform\PhplugPlatform;

use phplug\plugins\phplug_core\annotations\ReflectionAnnotatedClass;

use phplug\plugins\phplug_ajax_support\services\ServiceRegistry;

use phplug\platform\Phplugin;
use phplug\platform as pf;

class AjaxSupportPlugin extends Phplugin {
	
	private $servers;
	
	public function start() {
		$this->initServers();
		$this->initServices();
		$this->printServerResponse();
	}
	
	public function stop() {
		
	}
	
	private function initServices() {
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ajx.service")
							->getExtensions();
		foreach($extensions as $ext) {
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$implementation = $el->getAttribute("class");
			$class = new ReflectionAnnotatedClass($implementation);
			$name = $class->getAnnotation("Service")->value;
			self::$log->debug("Attempt to register Service with Name $name");
			$scope = $class->getAnnotation("Scope")->value;
			ServiceRegistry::instance()->registerService($name, $implementation, $scope);
		} 
	}
	
	private function initServers() {
		$this->servers = array();
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ajx.server")
							->getExtensions();
		foreach($extensions as $ext) {
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$implementation = $el->getAttribute("class");
			$class = new ReflectionAnnotatedClass($implementation);
			$name = $class->getAnnotation("Server")->value;
			$this->servers[$name] = $class->newInstance();
			self::$log->debug("registered Server ".$name);
		}
	}
	
	public function getServer() {
		return $this->servers[$this->getServerName()];
	}
	
	public function printServerResponse() {
		if(PhplugPlatform::getPluginById(CorePlugin::PLUGIN_ID)->isAjaxMode()) {
			echo $this->getServer()->getResponse();
		}
	}
	
	public function getServerName() {
		if(isset($_GET['phplugServerName'])) {
			$phplugServerName = $_GET['phplugServerName'];
		} else if(isset($_POST['phplugServerName'])) {
			$phplugServerName = $_POST['phplugServerName'];
		}
		return $phplugServerName;
	}
	
}