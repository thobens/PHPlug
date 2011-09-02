<?php
namespace phplug\plugins\phplug_ui\ui\views;

use phplug\plugins\phplug_ui\ui\layouts;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
abstract class ViewPart implements IViewPart {
	
	/**
	 * 
	 * @var ILayout
	 */
	protected $layout;
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/views/IViewPart#dispose()
	 */
	public function dispose() {
		// do nothing
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/views/IViewPart#init()
	 */
	public function init() {
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/views/IViewPart#getLayout()
	 */
	public function getLayout() {
		return $this->layout;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/views/IViewPart#setLayout()
	 */
	public function setLayout(layouts\ILayout $layout) {
		$this->layout = $layout;
	}
}