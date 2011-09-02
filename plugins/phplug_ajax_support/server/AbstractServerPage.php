<?php
namespace phplug\plugins\phplug_ajax_support\server;

use phplug\platform\PhplugLog;

abstract class AbstractServerPage implements IServerPage {
	
	private $data;
	
	private $scripts;
	
	private $assignments;
	
	public function __construct() {
		$this->data = array();
		$this->scripts = array();
		$this->assignments = array();
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function getScripts() {
		return $this->scripts;
	}
	
	public function getAssignments() {
		return $this->assignments;
	}
	
	public function assign($div, $assign) {
		$this->assignments[$div] = $assign;
	}
	
	public function callJSFunction($function) {
		$params = func_get_args();
		// get rid of the first param, as it's the same as $function
		array_shift($params);
		$funcCall = $function."(";
		$isFirst = true;
		foreach($params as $param) {
			if(is_string($param)) {
				$param = '"'.$param.'"';
			} else if(is_bool($param)) {
				$param = $param ? 'true' : 'false';
			}
			$funcCall .= ($isFirst?'':',').$param;
			$isFirst = false;			
		}
		$this->scripts[] = $funcCall.";";
	}
	
	public function setVar($var, $content) {
		$log = new PhplugLog();
		$log->debug("++++++++++++++++++++++++++++++++++++SET VAR".$var."=".$content);
		$this->data[$var] = $content;
	}
	
	public abstract function prepareResponse();
	
	public function printResponse() {
		header('Content-type: '.$this->getResponseType());
		echo $this->getResponse();
	}
	
}