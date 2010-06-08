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
	 * @var unknown_type
	 */
	private $filePath;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $xml;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $cache = array();
	
	
	
	/**
	 * 
	 * @param $filePath
	 * @return unknown_type
	 */
	public function __construct($filePath=null) {
		if($filePath==null) {
			$filePath = PHPLUG_DEFAULT_CONFIG_PATH;
		}
		$this->setFilePath($filePath);
		$this->fileRead = false;
		$this->xml = null;
	}
	
	/**
	 * 
	 * @param $filePath
	 * @return unknown_type
	 */
	public function setFilePath($filePath) {
		$this->filePath = $filePath;
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	public function getFilePath() {
		return $this->filePath;
	}
	
	/**
	 * 
	 * @return unknown_type
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
	 * @return unknown_type
	 */
	public function setConfig() {
		$this->xml = $this->readConfig();
	}
	
	/**
	 * 
	 * @param $key
	 * @return unknown_type
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