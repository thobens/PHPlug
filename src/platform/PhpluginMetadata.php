<?php
namespace phplug\platform;
/**
 * This class contains meta information about a plugin. The meta data is read from 
 * the corresponding plugin.xml
 * 
 * date: 2010-01-16
 *  
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 */
class PhpluginMetadata implements IPhpluginMetadata {
	
	/**
	 * 
	 * @var string
	 */
	public $id;
	
	/**
	 * 
	 * @var string
	 */
	public $classfile;
	
	/**
	 * 
	 * @var string
	 */
	public $class;
	
	/**
	 * 
	 * @var array(SimpleXmlElement)
	 */
	public $dependencies;
	
	/**
	 * 
	 * @var array(SimpleXmlElement)
	 */
	public $exports;
	
	/**
	 * 
	 * @var IPhpluginExtension
	 */
	public $extensions;
	
	/**
	 * 
	 * @var IPhpluginExtensionPoint
	 */
	public $extensionPoints;
}