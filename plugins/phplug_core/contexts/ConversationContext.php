<?php
namespace phplug\plugins\phplug_core\contexts;

class ConversationContext extends AbstractContext {
	
	private $id;
	
	public function initialize() {
		$_SESSION[Contexts::CONVERSATION_CONTEXT][$this->id] = array();
		parent::unserialize(Contexts::CONVERSATION_CONTEXT, $this->id);
		$this->notNew = array_keys($_SESSION[Contexts::CONVERSATION_CONTEXT][$this->id]);
	}
	
	public function set($var, $value) {
		$_SESSION[Contexts::CONVERSATION_CONTEXT][$this->id][$var] = $value;
	}
	
	public function get($var) {
		return $_SESSION[Contexts::CONVERSATION_CONTEXT][$this->id][$var];
	}
	
	public function getContextVars() {
		return $_SESSION[Contexts::CONVERSATION_CONTEXT][$this->id];
	}
	
	public function setId($id) {
		$this->id = $id;
	}
}