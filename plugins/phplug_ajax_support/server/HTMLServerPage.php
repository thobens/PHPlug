<?php
namespace phplug\plugins\phplug_ajax_support\server;

use phplug\platform\PhplugLog;

abstract class HTMLServerPage extends AbstractServerPage {
	
	protected $responseText;
	
	public function getResponseType() {
		return "text/html";
	}
	
	public function getResponse() {
		$this->prepareResponse();
		return $this->responseText;
	}
	
}