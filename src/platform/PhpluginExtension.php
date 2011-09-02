<?php
namespace phplug\platform;
/**
 * class PhpluginExtension
 * 
 * date: 2010-01-21
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class PhpluginExtension implements IPhpluginExtension {
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $configurationElements;
	
	private $declaringPlugin;
	
	/**
	 * Initializes the extension
	 */
	public function __construct() {
		$this->configurationElements = array();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginExtension#getConfigurationElements()
	 */
	public function getConfigurationElements() {
		return $this->configurationElements;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginExtension#addConfigurationElement()
	 */
	public function addConfigurationElement(IPhpluginConfigurationElement $element) {
		$this->configurationElements[] = $element;
	}
	
	public function getDeclaringPlugin() {
		return $this->declaringPlugin;
	}
	
	public function setDeclaringPlugin($declaringPlugin) {
		$this->declaringPlugin = $declaringPlugin;
	}
}