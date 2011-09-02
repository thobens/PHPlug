<?php
namespace phplug\platform;
/**
 * Phplugin
 * 
 * This is the abstract class for a plugin. It implements the phplug api interface IPhplugin
 * 
 * date: 2010-01-21
 *  
 * @see LICENSE.txt
 * @version 0.2
 * @author A. Doebeli <thobens@gmail.com>
 */
abstract class Phplugin implements IPhplugin {
	
	/**
	 * 
	 * @var string
	 */
	protected $id;
	
	/**
	 * 
	 * @var IPhpluginMetadata
	 */
	protected $metadata;
	
	/**
	 * 
	 * @var boolean
	 */
	protected $isLoaded;
	
	/**
	 * 
	 * @var PhplugLog
	 */
	protected static $log;
	

	/**
	 * 
	 * @param $id
	 * @return string
	 */
	public function __construct($id) {
		$this->id = $id;
		$this->isLoaded = true;
		$log = new PhplugLog();
		$log->info("init plugin $id");
		if(!isset(self::$log)) {
			self::$log = new PhplugLog();
		}
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isLoaded() {
		return $this->isLoaded;
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function reloadPlugin() {
	}
	
	/**
	 * 
	 * @param $metadata IPhpluginMetadata
	 */
	public function setMetadata(IPhpluginMetadata $metadata) {
		$this->metadata = $metadata;
	}
	
	/**
	 * 
	 * @return IPhpluginMetadata
	 */
	public function getMetadata() {
		return $this->metadata;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	
}