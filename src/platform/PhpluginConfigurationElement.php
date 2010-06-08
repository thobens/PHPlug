<?php
namespace phplug\platform;
/**
 * class PhpluginConfigurationElement
 * 
 * date: 2010-01-21
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class PhpluginConfigurationElement implements IPhpluginConfigurationElement {
	
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * 
	 * @var string
	 */
	private $value;
	
	/**
	 * 
	 * @var array
	 */
	private $attributes;
	
	/**
	 * 
	 * @var array
	 */
	private $children;
	
	/**
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->attributes = array();
		$this->children = array();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginConfigurationElement#getName()
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginConfigurationElement#getChildren()
	 */
	public function getChildren() {
		return $this->children;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginConfigurationElement#getValue()
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginConfigurationElement#getAttribute()
	 */
	public function getAttribute($name) {
		return @$this->attributes[$name];
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginConfigurationElement#addChild()
	 */
	public function addChild(IPhpluginConfigurationElement $element) {
		$this->children[$element->getName()] = $element;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginConfigurationElement#setValue()
	 */
	public function setValue($value) {
		$this->value = $value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginConfigurationElement#setAttribute()
	 */
	public function setAttribute($name, $value) {
		$this->attributes[$name] = $value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IPhpluginConfigurationElement#setName()
	 */
	public function setName($name) {
		$this->name = $name;	
	}
}