<?php
namespace phplug\plugins\phplug_ui_processor\uiprocessor;

use phplug\platform as pf,
	phplug\plugins\phplug_ui\ui,
	phplug\plugins\phplug_ui_processor;

require_once("smarty/Smarty.class.php");
/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class DefaultUIProcessor implements ui\UIProcessor {
	
	private $smarty;
	
	private $assignments;
	
	private $templateStore;
	
	public function __construct() {
		$this->smarty = new \Smarty();
		$this->smarty->compile_dir = pf\PhplugPlatform::getConfig()->getConfigEntry(PHPLUG_CFG_PLUGINDIR)."/".phplug_ui_processor\UIProcessorPlugin::ID."/templates_c";
		$this->assignments = array();
		$this->templateStore = TemplateStore::getSingleton();
	}
	
	public function assign($var,$value) {
		$this->assignments[$var] = $value;
	}
	
	public function process($id = null) {
		if($id==null) {
			$template = pf\PhplugPlatform::getActiveWorkbench()->getTemplate();
			$pdir = pf\PhplugPlatform::getConfig()->getConfigEntry(PHPLUG_CFG_PLUGINDIR);
			if(substr($pdir,0,1)==".") {
				$pdir = substr($pdir,1);
			}
			$template = ereg_replace("\\\$pluginPath", 
							$pdir.
							"/phplug_ui",
							$template);
		} else {
			$template = $this->templateStore->getTemplate($id);
		}
		$template = $_SERVER["DOCUMENT_ROOT"].$template;
		foreach($this->assignments as $var => $value) {
			$this->smarty->assign($var,$value);
		}
		$this->assignments = array();
		return $this->smarty->fetch($template);
	}
}