<?php
namespace phplug\plugins\phplug_ajax_support\services;

use phplug\platform\PhplugLog;

use phplug\plugins\phplug_core\annotations\ReflectionAnnotatedClass;

use phplug\plugins\phplug_core\CorePlugin;

use phplug\platform\PhplugPlatform;

use phplug\plugins\phplug_ajax_support\server\JSONServerPage;

/**
 * 
 * Enter description here ...
 * @author adobel
 * @Server("servicesServer")
 */
class ServicesServerPage extends JSONServerPage {

	public function prepareResponse() {
		$log = new PhplugLog();
		if(isset($_GET['serviceName'])) {
			$serviceName = $_GET['serviceName'];
		} else if(isset($_POST['serviceName'])) {
			$serviceName = $_POST['serviceName'];
		}
		if(isset($_GET['p[]'])) {
			$params = $_GET['p[]'];
		} else if(isset($_POST['p[]'])) {
			$params = $_POST['p[]'];
		} else {
			$params = array();
		}
		if(isset($_GET['method'])) {
			$methodName = $_GET['method'];
		} else if(isset($_POST['method'])) {
			$methodName = $_POST['method'];
		}
		
		if($serviceName) {
			$service = ServiceRegistry::instance()->getService($serviceName);
			$serviceClass = new ReflectionAnnotatedClass($service);
			$rMethod = $serviceClass->getMethod($methodName);
			$rMethod->invokeArgs($service, $params);
			$props = $serviceClass->getProperties();
			$values = array();
			foreach($props as $property) {
				if($property->hasAnnotation("Expose")) {
					$property->setAccessible(true);
					$this->setVar($property->getName(), $property->getValue($service));
					$property->setAccessible(false);
				}
			}
		}
	}

}