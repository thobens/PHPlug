<?php
namespace phplug\plugins\thobens_web_testpage\services;

/**
 * 
 * @author adobel
 * @Service("helloWorldService")
 * @Scope("phplug_session_ctxt")
 */
class HelloWorldService  {
	
	/**
	 * @var string
	 * @Expose
	 */
	private $helloWorld;
	
	public function alertHelloWorldString() {
		$this->helloWorld= "Hello World Service";
	}

}