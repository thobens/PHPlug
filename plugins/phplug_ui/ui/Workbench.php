<?php
namespace phplug\plugins\phplug_ui\ui;

use phplug\platform as pf;

/**
 *
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Workbench implements pf\IWorkbench {

	/**
	 *
	 * @var unknown_type 
	 */
	private static $INSTANCE;

	/**
	 *
	 * @var string
	 */
	private $activePerspective;

	/**
	 *
	 * @var unknown_type
	 */
	private $template;

	/**
	 *
	 * @var array
	 */
	private $perspectives;

	/**
	 * 
	 * @var UIProcessor
	 */
	private $uiProcessor;
	
	/**
	 * 
	 * @var string
	 */
	const DEFAULT_PERSPECTIVE_ID = "ch.thobens.phplug.ui.perspectives.default";

	/**
	 * TODO should be singleton pattern...
	 */
	public function __construct() {
		
	}

	/**
	 *
	 * @return unknown_type
	 */
	public static function getSingleton() {
		if(!isset(self::$INSTANCE)) {
			self::$INSTANCE = new self;
		}
		return self::$INSTANCE;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IWorkbench#registerPerspective()
	 */
	public function registerPerspective($id, $perspective) {
		$this->perspectives[$id] = $perspective;
	}

	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IWorkbench#setPerspective()
	 */
	public function setPerspective($perspectiveId) {
		$this->activePerspective = $perspectiveId;
	}

	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IWorkbench#draw()
	 */
	public function draw() {
		$this->getActivePerspective()->createInitialLayout();
		$this->uiProcessor->assign("Workbench",$this->getActivePerspective()->draw());
		echo $this->uiProcessor->process();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/IWorkbench#getActivePerspective()
	 */
	public function getActivePerspective() {
		return $this->perspectives[$this->activePerspective];
	}
	
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
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IWorkbench#getUIProcessor()
	 */
	public function getUIProcessor() {
		return $this->uiProcessor;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/inc/IWorkbench#setUIProcessor()
	 */
	public function setUIProcessor($uiProcessor) {
		$this->uiProcessor = $uiProcessor;
	}
	
}