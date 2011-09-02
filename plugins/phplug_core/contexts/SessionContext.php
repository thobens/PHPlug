<?php
namespace phplug\plugins\phplug_core\contexts;

class SessionContext extends AbstractContext {
	
	public function initialize() {
		$_SESSION[Contexts::SESSION_CONTEXT][session_id()] = array();
		parent::unserialize(Contexts::SESSION_CONTEXT, session_id());
		$this->notNew = array_keys($_SESSION[Contexts::SESSION_CONTEXT][session_id()]);
	}
	
	public function set($var, $value) {
		$_SESSION[Contexts::SESSION_CONTEXT][session_id()][$var] = $value;
	}
	
	public function get($var) {
		return $_SESSION[Contexts::SESSION_CONTEXT][session_id()][$var];
	}
	
	public function getContextVars() {
		return $_SESSION[Contexts::SESSION_CONTEXT][session_id()];
	}
}