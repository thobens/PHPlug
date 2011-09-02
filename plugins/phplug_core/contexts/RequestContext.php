<?php
namespace phplug\plugins\phplug_core\contexts;

class RequestContext extends AbstractContext {
	
	public function initialize() {
		$_SESSION[Contexts::REQUEST_CONTEXT][0] = array();
	}
	
	public function set($var, $value) {
		$_REQUEST[Contexts::REQUEST_CONTEXT][$var][0] = $value;
	}
	
	public function get($var) {
		return $_REQUEST[Contexts::REQUEST_CONTEXT][0][$var];
	}
	
	public function getContextVars() {
		return $_SESSION[Contexts::REQUEST_CONTEXT][0];
	}
}