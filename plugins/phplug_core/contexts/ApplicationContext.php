<?php
namespace phplug\plugins\phplug_core\contexts;

class ApplicationContext extends AbstractContext {
	
	private $vars;
	
	public function initialize() {
		$this->vars = array();
		parent::unserialize(Contexts::APPLICATION_CONTEXT, Contexts::APP_CTX_IDENTIFIER);
		$this->notNew = array_keys($this->vars);
	}
	
	public function set($var, $value) {
		$this->vars[$var] = $value;
	}
	
	public function get($var) {
		return $this->vars[$var];
	}
	
	public function getContextVars() {
		return $this->vars;
	}
}