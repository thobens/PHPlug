<?php
namespace phplug\plugins\phplug_ajax_support\server;

class Assign {
	
	private $div;
	
	private $attribute;
	
	private $content;
	
	public function __construct($div, $attribute, $content) {
		$this->div = $div;
		$this->attribute = $attribute;
		$this->content = $content;
	}
	
	public function getDiv() {
		return $this->div;
	}
	
	public function getAttribute() {
		return $this->attribute;
	}
	
	public function getContent() {
		return $this->content;
	}
	
}