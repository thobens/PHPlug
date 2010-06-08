<?php
namespace phplug\platform;
/**
 * class PhpluginManager
 * 
 * Manages the plugins on the server
 * 
 * date: 2010-01-12
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class PhpluginManager implements IPhpluginManager {
	
	
	/**
	 * 
	 * @var unknown_type
	 */
	public $errMsg;
	
	
	
	/**
	 * Init...
	 */
	public function __construct() {
		$this->errMsg = array();
	}
	
	
	
	/**
	 * Installs a plugin, based on the phplug config and the plugin.xml from the specific plugin
	 * 
	 * @param $location string 			the filename of the zipped plugin in the package folder
	 * @param $removeFileAfterInstall	indicates if the zip file will be deleted from the server after installing
	 * @return boolean	true, if installation completed without problems, otherwise false
	 */
	public function installPlugin($location, $removeFileAfterInstall=false) {
		$phplug_cfg = PhplugPlatform::getConfig();
		$error="";
		$pkgdir = $phplug_cfg->getConfigEntry(PHPLUG_CFG_PKGDIR);
		$location = $pkgdir."/".$location;
		$hasError = false;
		$zip = new PclZip($location);
		
		// read the plugin.xml file to get the plugin id
		$list = $zip->extract(PCLZIP_OPT_BY_NAME, "plugin.xml", PCLZIP_OPT_EXTRACT_AS_STRING);
		if($list==0) {
			$this->errMsg[] = $zip->errorInfo();
			return false;
		}
		$xml = simplexml_load_string($list[0]['content']);
		$pluginId = $xml->xpath("/plugin/@id");
		$pluginId = $pluginId[0];
		
		// create the plugin directory
		$target = $phplug_cfg->getConfigEntry(PHPLUG_CFG_PLUGINDIR)."/".$pluginId;
		if(file_exists($target)) {
			$this->errMsg[] = "Plugin already exists. Remove the old plugin and then install the new one.";
			$hasError = true;
		} else {
			if($zip->extract(PCLZIP_OPT_PATH, $target, PCLZIP_OPT_STOP_ON_ERROR) == 0) {
				$this->errMsg[] = "Failed to read Zip file! (error:".$zip->errorInfo().")";
				$hasError = true;
			} else {
				chmod_recursive($target,0777);
			}
		}
		
		$dom = new DOMDocument();
		//TODO save platform information in platform.xml
		
		return !$hasError;
	}

	
	
	/**
	 * Completely removes a plugin from the file system
	 * 
	 * @param $id	the id of the plugin defined in it's plugin.xml file
	 * @return boolean	true, if the plugin was removed correctly, otherwise false
	 */
	public function removePlugin($id) {
		$phplug_cfg = PhplugPlatform::getConfig();
		$dir = $phplug_cfg->getConfigEntry(PHPLUG_CFG_PLUGINDIR)."/".$id;
		$dom = new DOMDocument();
		//TODO remove plugin from platform.xml file
		return delete_directory($dir);
	}
	
	
	
	/**
	 * Activates a plugin. After activation it can be used in the whole application
	 * 
	 * @param $id
	 * @return unknown_type
	 */
	public function activatePlugin($id) {
		//TODO implement...
	}
	
	
	
	/**
	 * Deactivates a plugin. If one is deactivated, it cannot be used anymore, but it's still on the file system
	 * 
	 * @param $id
	 * @return unknown_type
	 */
	public function deactivatePlugin($id) {
		//TODO implement....
	}
}