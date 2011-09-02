<?php
namespace phplug\plugins\phplug_ui\ui\layouts;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
use phplug\platform\PhplugLog;

use phplug\plugins\phplug_ui\ui\CompositePool;

use phplug\plugins\phplug_ui\ui\IComposite;

abstract class Layout implements ILayout {
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $template;
	
	/**
	 * 
	 * @var unknown_type
	 */
	protected $composites;
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/Templateable#getTemplate()
	 */
	public function getTemplate() {
		return $this->template;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/Templateable#setTemplate()
	 */
	public function setTemplate($template) {
		$this->template = $template;
	}
	
	public function addComposite(IComposite $composite) {
		$log = new PhplugLog();
		CompositePool::getInstance()->addComposite($composite);
	}
	
}