<?php
namespace phplug\platform;
/**
 * PhplugException
 * 
 * Standard Exception class for the Phplug framework
 * 
 * date: 2010-05-26
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class PhplugException extends \Exception {
	
	private static $log;
	
	public function __construct($msg,$code=0) {
		parent::__construct($msg,$code);
		self::$log = new PhplugLog();
		self::$log->error("Exception created. saying: ".$msg." (errCode=$code)");
	}
	
}