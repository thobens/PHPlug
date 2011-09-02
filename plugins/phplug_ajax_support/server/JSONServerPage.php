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
		$data = implode(",", $values);
		$response .= $data;
		$response .= "};";
		return $response;
	}
	
}