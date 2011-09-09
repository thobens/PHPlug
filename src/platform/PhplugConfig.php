<?php
namespace phplug\platform;
/**
 * PhplugConfig
 * 
 * Configuration class for the Phplug framework
 * 
 * date: 2010-01-10
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class PhplugConfig {
	
	/**
	 * 
	 * @var string
	 */
	private $filePath;
	
	/**
	 * 
	 * @var SimpleXMLElement
	 */
	private $xml;
	
	/**
	 * 
	 * @var array
	 */
	private $cache = array();
	
	
	
	/**
	 * 
	 * @param $filePath
	 */
	public function __construct($filePath=null) {
		if($filePath==null) {
			$filePath = dirname(__FILE__).'/../../../'.PHPLUG_DEFAULT_CONFIG_PATH;
		}
		$this->setFilePath($filePath);
		$this->fileRead = false;
		$this->xml = null;
	}
	
	/**
	 * 
	 * @param $filePath
	 * @return void
	 */
	public function setFilePath($filePath) {
		$this->filePath = $filePath;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getFilePath() {
		return $this->filePath;
	}
	
	/**
	 * 
	 * @return SimpleXMLElement
	 */
	public function readConfig() {
		$path = $this->getFilePath();
		if (file_exists($path)) {
			$this->fileRead = true;
			return simplexml_load_file($path);
		} else {
			exit ("Konnte Datei \"$path\" nicht laden.");
		}
	}
	
	/**
	 * 
	 * @return void
	 */
	public function setConfig() {
		$this->xml = $this->readConfig();
	}
	
	/**
	 * 
	 * @param $key the key of the config entry
	 * @return string
	 */
	public function getConfigEntry($key) {
		if(!$this->xml != null) {
			$this->setConfig();
		}
		//simple cache mechanism to minimize xpath queries
		if(!array_key_exists($key,$this->cache)) {
			$xpath = "/config/entry[@key='$key']/@value";
			$result = $this->xml->xpath($xpath);
			$this->cache[$key] = $result[0];
		}
		return $this->cache[$key];
	}
}