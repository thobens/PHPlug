<?php
namespace phplug\platform;
/**
 * class PhpluginExtensionPointRegistry
 * 
 * Holds the ExtensionPoints that are defined in the plugins
 * 
 * date: 2010-01-29
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class PhpluginExtensionRegistry implements IPhpluginExtensionRegistry {
	
	/**
	 * 
	 * @var array(IPhpluginExtensionPoint)
	 */
	private $extensionPoints;
	
	/**
	 * 
	 * @var array
	 */
	private $extensionPointpluginMapping;
	
	/**
	 * 
	 * @var PhplugLog
	 */
	private static $log;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		self::$log = new PhplugLog();
		$this->extensionPoints = array();
		$this->extensionPointpluginMapping = array();
	}
	
	/**
	 * 
	 * @param $extensionPointId
	 * @return IPhpluginExtensionPoint
	 */
	public function getExtensionPoint($extensionPointId) {
		return $this->extensionPoints[$extensionPointId];
	}
	
	/**
	 * Registers an extensionPoint. All plugin.xml files within this platform
	 * will be read and the extensions appropriate to the given extensionPoint
	 * will be created and registered.
	 * 
	 * @param $point the extensionPointObject that needs to be registered
	 * @param $pluginId the id of the plugin that declares this extensionPoint
	 * @return void
	 */
	public function registerExtensionPoint(IPhpluginExtensionPoint $point, $pluginId) {
		$plugins = PhplugPlatform::getPlugins();
		$cfg = PhplugPlatform::getConfig();
		$this->extensionPointpluginMapping[$point->getId()] = $pluginId;
		foreach($plugins as $plugin) {
			$md = $plugin->getMetadata();
			$xpath = "//extension[@point='".$point->getId()."']";
			if($md->extensions) {
				$pext = $md->extensions[0]->xpath($xpath);
				foreach($pext as $ext) {
					foreach($ext->children() as $child) {
						$dom = new \DOMDocument();
						$dom->loadXML($child->asXML());
						$schema = $cfg->getConfigEntry(PHPLUG_CFG_PLUGINDIR)."/".$pluginId."/".$point->getSchema();
						if($dom->schemaValidate($schema)) {
							self::$log->debug("creating extension...");
							$elements = $this->createConfigurationElements($child);
							$extension = new PhpluginExtension();
							$extension->addConfigurationElement($elements);
							$point->addExtension($extension);
						}
					}
				}
			}
		}
		$this->extensionPoints[$point->getId()] = $point;
		self::$log->debug("Registered ExtensionPoint ".$point->getId());
	}
	
	/**
	 * 
	 * @param $node
	 * @return unknown_type
	 */
	private function createConfigurationElements(\SimpleXMLElement $node) {
		$ce = new PhpluginConfigurationElement();
		$ce->setName($node->getName());
		foreach($node->attributes() as $key=>$attr) {
			$ce->setAttribute($key, (string)$attr);
		}
		if(sizeof($node->children()) > 0) {
			$children = array();
			foreach($node->children() as $childNode) {
				$ce->addChild($this->createConfigurationElements($childNode));
			}
		} else {
			$ce->setValue((string)$node);	
		}
		return $ce;
	}
}