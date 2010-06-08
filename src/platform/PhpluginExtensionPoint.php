<?php
namespace phplug\platform;
/**
 * class PhpluginExtensionPoint
 * 
 * date: 2010-01-21
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class PhpluginExtensionPoint implements IPhpluginExtensionPoint {
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $id;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $name;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $schema;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private static $log;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $extensions;
	
	
	
	/**
	 * Initializes the extension point
	 * 
	 * @param $id
	 * @param $name
	 * @param $schema
	 * @return unknown_type
	 */
	public function __construct($id, $name, $schema) {
		$this->id 		= $id;
		$this->name 	= $name;
		$this->schema	= $schema;
		$this->extensions = array();
		self::$log = new PhplugLog();
	}
	
	/**
	 * @see phplug/inc/IPhpluginExtensionPoint#getExtensions()
	 */
	public function getExtensions() {
		return $this->extensions;
	}
	
	/**
	 * @see phplug/inc/IPhpluginExtensionPoint#addExtension()
	 */
	public function addExtension(IPhpluginExtension $ext) {
		$this->extensions[] = $ext;
	}
	
	/**
	 * @see phplug/inc/IPhpluginExtensionPoint#getId()
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @see phplug/inc/IPhpluginExtensionPoint#getName()
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @see phplug/inc/IPhpluginExtensionPoint#getSchema()
	 */
	public function getSchema() {
		return $this->schema;
	}
	
	/**
	 * 
	 * @param $id
	 * @return unknown_type
	 */
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 * 
	 * @param $name
	 * @return unknown_type
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * 
	 * @param $schema
	 * @return unknown_type
	 */
	public function setSchema($schema) {
		$this->schema = $schema;
	}
	
}