<?php
namespace phplug\platform;
/**
 * phplug.api.php
 * 
 * The API of the framework. It defines the Interfaces that 
 * will be used through the whole project.
 * 
 * date: 2010-01-11
 *  
 * @see LICENSE.txt
 * @version 0.2
 * @author A. Doebeli <thobens@gmail.com>
 */

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhplugin {
	
	/**
	 * 
	 * @return unknown_type
	 * @throws PhplugException
	 */
	public function start();
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function stop();
}



/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhpluginManager {
	
	/**
	 * 
	 * @param $file
	 * @param $removeAfterInstall
	 * @return unknown_type
	 */
	public function installPlugin($file,$removeAfterInstall=false);
	
	/**
	 * 
	 * @param $id
	 * @return unknown_type
	 */
	public function removePlugin($id);
	
	/**
	 * 
	 * @param $id
	 * @return unknown_type
	 */
	public function activatePlugin($id);
	
	/**
	 * 
	 * @param $id
	 * @return unknown_type
	 */
	public function deactivatePlugin($id);
}




/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhpluginConfigurationElement {
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getChildren();
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getValue();
	
	/**
	 * 
	 * @param $name
	 * @return unknown_type
	 */
	public function getAttribute($name);
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getName();
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function addChild(IPhpluginConfigurationElement $element);
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function setValue($value);
	
	/**
	 * 
	 * @param $name
	 * @return unknown_type
	 */
	public function setAttribute($name, $value);
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function setName($name);
	
	
}



/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhpluginExtension {
	
	/**
	 * 
	 * @return IPhpluginConfigurationElement
	 */
	public function getConfigurationElements();
	
	/**
	 * 
	 * @param $element
	 * @return unknown_type
	 */
	public function addConfigurationElement(IPhpluginConfigurationElement $element);
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function getDeclaringPlugin();
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $declaringPlugin
	 */
	public function setDeclaringPlugin($declaringPlugin);
}



/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhpluginExtensionPoint {
	
	/**
	 * 
	 * @return array(IPhpluginExtension)
	 */
	public function getExtensions();
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getId();
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getSchema();
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getName();
	
	/**
	 * 
	 * @param $extension
	 * @return unknown_type
	 */
	public function addExtension(IPhpluginExtension $extension);
	
}

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhpluginExtensionRegistry {
	
	/**
	 * 
	 * @param $extensionPointId
	 * @return unknown_type
	 */
	public function getExtensionPoint($extensionPointId);
	
	/**
	 * 
	 * @param $point
	 * @param $pluginId the id of the plugin that declares this extensionPoint
	 * @return unknown_type
	 */
	public function registerExtensionPoint(IPhpluginExtensionPoint $point, $pluginId); 
}


/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhpluginMetadata {
	
}



/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhplugPlatform {
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function preparePlugins();
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function loadPlatform();
	
	/**
	 * 
	 * @param $workbench
	 * @return unknown_type
	 */
	public static function setActiveWorkbench(IWorkbench $workbench);
	
	/**
	 * 
	 * @return IWorkspace
	 */
	public static function getActiveWorkbench();
	
}

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IPhplugWorkspace {
	
}

interface Templateable {
	/**
	 * Set the template of the Workbench
	 * @return string The template path
	 */
	public function getTemplate();
	
	/**
	 * Set the template of the Workbench
	 * @param $template The path to the template
	 */
	public function setTemplate($template);
}

/**
 *
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
interface IWorkbench extends Templateable {
	
	/**
	 * 
	 * @param $id
	 * @param $perspective
	 * @return void
	 */
	public function registerPerspective($id, $perspective);
	
	/**
	 *
	 * @param $perspective
	 * @return unknown_type
	 */
	public function setPerspective($perspectiveId);
	
	/**
	 * 
	 * @return IPerspective
	 */
	public function getActivePerspective();

	/**
	 *
	 * @return void
	 */
	public function draw();

	
	/**
	 * 
	 * @return UIProcessor
	 */
	public function getUIProcessor();
	
	/**
	 * 
	 * @param $uiprocessor
	 * @return void
	 */
	public function setUIProcessor($uiprocessor);
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $banner
	 */
	public function setBanner($banner);
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function getBanner();

	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $applicationTitle
	 */
	public function setApplicationTitle($applicationTitle);
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function getApplicationTitle();
}