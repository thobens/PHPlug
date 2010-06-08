<?php
/**
 * phplug.inc.php
 * 
 * Defines constants.
 * 
 * date: 2010-01-10
 *  
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 */

// Environment
define("PHPLUG_DEFAULT_CONFIG_PATH",		"PHPlug/config/config.xml");
define("PHPLUG_PLATFORM_DEFINITION",		"config/platform.xml");
define("PHPLUG_PLATFORM_STATE_VAR",			"phplug_platform_state");
define("PHPLUG_VERSION",					"1.0");

// Config entry keys (see $DOCROOT/phplug/dat/xml/config.xml for the meaning of the entries)
define("PHPLUG_CFG_ROOTDIR", 				"ch.thobens.phplug.rootdir");
define("PHPLUG_CFG_PLUGINDIR",				"ch.thobens.phplug.plugindir");
define("PHPLUG_CFG_PKGDIR",					"ch.thobens.phplug.packagedir");
define("PHPLUG_CFG_TMPDIR",					"ch.thobens.phplug.tmpdir");
define("PHPLUG_CFG_LOGCFG",					"ch.thobens.phplug.logcfg");
define("PHPLUG_CFG_LOGFILE",				"ch.thobens.phplug.logfile");
define("PHPLUG_CFG_DEBUGMODE",				"ch.thobens.phplug.debugmode");
define("PHPLUG_CFG_ADMIN_MAIL",				"ch.thobens.phplug.admin.mail");
define("PHPLUG_CFG_PHP_EXTENSIONS",			"ch.thobens.phplug.php.extensions");

// Logging constants
define("PHPLUG_LOG_LVL_INFO", 				"INFO");
define("PHPLUG_LOG_LVL_WARN", 				"WARN");
define("PHPLUG_LOG_LVL_ERROR", 				"ERROR");
define("PHPLUG_LOG_LVL_DEBUG", 				"DEBUG");
define("PHPLUG_LOG_LVL_TRACE", 				"TRACE");