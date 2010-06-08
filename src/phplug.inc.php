<?php
/**
 * phplug.inc.php
 *
 * initializes the framework
 *
 * date: 2010-01-10
 *
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 */
//session start
session_start();

// required includes
require_once 'def.inc.php';
require_once 'phplug.api.php';
require_once 'PHPlug/lib/pclzip.lib.php';
require_once 'PHPlug/lib/phplug.lib.php';
require_once 'platform/Phplugin.php';
require_once 'platform/PhplugLog.php';
require_once 'platform/PhplugConfig.php';
require_once 'platform/PhplugException.php';
require_once 'platform/PhpluginManager.php';
require_once 'platform/PhpluginMetadata.php';
require_once 'platform/PhpluginExtension.php';
require_once 'platform/PhpluginExtensionPoint.php';
require_once 'platform/PhpluginExtensionRegistry.php';
require_once 'platform/PhpluginConfigurationElement.php';
require_once 'platform/PhplugPlatform.php';

use phplug\platform as pf;

// initialization
$__phplug_platform = pf\PhplugPlatform::getSingleton();
$__phplug_platform->preparePlugins();
if(!$__phplug_platform->loadPlatform()) {
	$admin = pf\PhplugPlatform::getConfig()->getConfigEntry(PHPLUG_CFG_ADMIN_MAIL);
	echo "Error loading platform... See log for details or cantact your <a href=\"mailto:$admin\">administrator</a>!";
}

// define the autoloader
function __autoload($class_name) {
	$success = false;
	$log = new pf\PhplugLog();
	$path = str_replace("phplug\\plugins",pf\PhplugPlatform::getConfig()->getConfigEntry(PHPLUG_CFG_PLUGINDIR),$class_name);
	$path = str_replace("\\","/",$path);
	$path .= ".php";
	if(file_exists($path)) {
		require_once $path;
		$success = true;
	}
	if(!$success) {
		$log->error("No class file found to autoload for class $class_name (tried $path)");
	}
}