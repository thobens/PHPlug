<?php
namespace phplug\platform;
/**
 * class PhplugLog
 * 
 * date: 2010-02-17
 *
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 * 
 */
class PhplugLog {
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $logFilePath;

	/**
	 * 
	 * @var unknown_type
	 */
	private $class;

	/**
	 * 
	 * @var unknown_type
	 */
	private $callMaxChars;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $debugEnabled;
	
	/**
	 * 
	 * debugLevels mapped to precedence
	 * @var array
	 */
	private $debugLevels;
	
	
	/**
	 * 
	 * @param $class
	 * @return unknown_type
	 */
	public function __construct() {
		$this->callMaxChars = 50;
		$this->logFilePath = "./PHPlug/log/out.log";
		$this->debugEnabled = true;
		$this->debugLevels = array();
		$this->debugLevels[PHPLUG_LOG_LVL_INFO]	= 1000;
		$this->debugLevels[PHPLUG_LOG_LVL_WARN] = 800;
		$this->debugLevels[PHPLUG_LOG_LVL_ERROR] = 600;
		$this->debugLevels[PHPLUG_LOG_LVL_DEBUG] = 400;
		$this->debugLevels[PHPLUG_LOG_LVL_TRACE] = 200;
	}
	
	/**
	 * 
	 * @param $lvl
	 * @param $msg
	 * @return unknown_type
	 */
	private function log($lvl, $msg) {
		$fp = @fopen($this->logFilePath,"a+");
		$date = date("H:i:s");
		$call = $this->getCallFixedWidth();
		@fwrite($fp,"[$date] $call $lvl: $msg\n");
		@fclose($fp);
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	private function getCallFixedWidth() {
		$backtrace = $this->getBacktrace();
		$file = $backtrace['file'];
//		$tmp = explode("/",$file);
		
		// remove the filename from the path
		unset($tmp[sizeof($tmp)-1]);
//		$package = implode(".",$tmp);
		$cfw = $backtrace['class'];
		if($cfw == '') {
			$cfw = $file;
		}
		
		// if call is longer than needed, just the last n ( = $this->callMaxChars)
		// letters will be used
		if($len = strlen($cfw)>$this->callMaxChars) {
			$cfw = substr($cfw,$len-($this->callMaxChars+1));
		} else {
			// otherwise fill up with spaces
			while(strlen($cfw)<$this->callMaxChars) {
				$cfw .= " ";
			}
		}
		return $cfw;
	}
	
	/**
	 * Returns the actual backtrace that is needed for the log entry
	 * 
	 * @return array
	 */
	private function getBacktrace() {
		$backtrace = debug_backtrace();
		$last = "";
		$i = 0;
		for($i=0;$i<sizeof($backtrace);$i++) {
			if($i==0) {
				$last = $backtrace[$i]["class"];
			}
			if($last!=$backtrace[$i]["class"]) {
				break;
			}
		}
		// check if the calling method is a magic function (except __construct)
		if(substr($backtrace[$i]["function"],0,2)=="__" &&
				  $backtrace[$i]["function"]!="__construct") {
			// in this case we can skip two more trace levels
			return $backtrace[$i+2];
		} else {
			// otherwise we only skip trace levels 
			// until the calling method is reached
			return $backtrace[$i];
		}
	}
	
	/**
	 * 
	 * @param $msg
	 * @return unknown_type
	 */
	public function info($msg) {
		return $this->log(PHPLUG_LOG_LVL_INFO, $msg);
	}
	
	/**
	 * 
	 * @param $msg
	 * @return unknown_type
	 */
	public function warn($msg) {
		return $this->log(PHPLUG_LOG_LVL_WARN, $msg);
	}
	
	/**
	 * 
	 * @param $msg
	 * @return unknown_type
	 */
	public function error($msg) {
		return $this->log(PHPLUG_LOG_LVL_ERROR, $msg);
	}
	
	/**
	 * 
	 * @param string $msg
	 * @return unknown_type
	 */
	public function trace($msg) {
		return $this->log(PHPLUG_LOG_LVL_TRACE, $msg);
	}
	
	/**
	 * 
	 * @param $msg
	 * @return unknown_type
	 */
	public function debug($msg) {
		if($this->debugEnabled) {
			return $this->log(PHPLUG_LOG_LVL_DEBUG, $msg);
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	private function readConfig() {
		$path = PhplugPlatform::getSingleton()->getConfig()->getConfigEntry(PHPLUG_CFG_LOGCFG);
		if (file_exists($path)) {
			return simplexml_load_file($path);
		} else {
			exit ("Konnte Datei \"$path\" nicht laden.");
		}
	}
}