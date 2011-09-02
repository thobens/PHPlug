<?php
namespace phplug\plugins\phplug_ajax_support\server;

interface IServerPage {
	
	public function printResponse();
	
	public function getResponse();
	
	public function getResponseType();
	
}