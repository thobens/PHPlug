<?php
namespace phplug\plugins\phplug_ajax_support\server;

use phplug\platform\PhplugLog;

abstract class JSONServerPage extends AbstractServerPage {
	
	public function getResponseType() {
		return "text/javascript";
	}
	
	public function getResponse() {
		$response = "responseObj = {";
		$values = array();
		$log = new PhplugLog();
		$this->prepareResponse();
		foreach($this->getData() as $var => $data) {
			if(is_string($data)) {
				$data = '"'.$data.'"';
			} else if(is_bool($data)) {
				$data = $data ? 'true' : 'false';
			}
			$values[] = $var.":".$data;
		}
		$data = "";
		if(sizeof($values)>0) {
			$data .= "data:{".implode(",", $values)."}";
		} 
		$response .= $data;
		$values = array();
//		foreach($this->getScripts() as $script) {
//			$values[] = $script;
//		}
//		$response .= (strlen($data)>0?',':'').implode(";", $values);
		
		
		foreach($this->getData() as $var => $data) {
			if(is_string($data)) {
				$data = '"'.$data.'"';
			} else if(is_bool($data)) {
				$data = $data ? 'true' : 'false';
			}
			$values[] = $var.":".$data;
		}
		
		$response .= "};";
		return $response;
	}
	
}