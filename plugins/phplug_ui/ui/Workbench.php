<?php
namespace phplug\plugins\phplug_ui\ui;

use phplug\platform\PhplugLog;

use phplug\plugins\phplug_core\CorePlugin;

use phplug\plugins\phplug_ui\UIPlugin;

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
	 * Enter description here ...
	 * @var unknown_type
	 */
	private $banner;
	
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	private $applicationTitle;
	
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
		$log = new PhplugLog();
		$log->debug("registering perspective: ". $perspective->getId());
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
		$this->uiProcessor->assign("banner",$this->banner);
		$this->uiProcessor->assign("applicationTitle",$this->applicationTitle);
		$this->uiProcessor->assign("Workbench",$this->getActivePerspective()->draw());
		if(!pf\PhplugPlatform::getPluginById(CorePlugin::PLUGIN_ID)->isAjaxMode()) {
			echo $this->uiProcessor->process();
		}
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
	
	/**
	 * (non-PHPdoc)
	 * @see phplug\platform.IWorkbench::setBanner()
	 */
	public function setBanner($banner) {
		$this->banner = $banner;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see phplug\platform.IWorkbench::getBanner()
	 */
	public function getBanner() {
		return $this->banner;
	}
	
	public function setApplicationTitle($applicationTitle) {
		$this->applicationTitle = $applicationTitle;
	}
	
	public function getApplicationTitle() {
		return $this->applicationTitle;
	}
	
}