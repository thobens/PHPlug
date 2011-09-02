<?php
namespace phplug\plugins\phplug_ui;
use phplug\plugins\phplug_core\annotations\ReflectionAnnotatedClass;

use phplug\plugins\phplug_ui\ui\CompositePool;

use phplug\platform\PhplugPlatform;

use phplug\plugins\phplug_core\CorePlugin;

use phplug\platform as pf,
	phplug\plugins\phplug_ui\ui;
class UIPlugin extends pf\Phplugin {
	
	/**
	 * 
	 * @var IWorkbench
	 */
	private static $workbench;
	
	private $menus;
	
	const PLUGIN_ID = "phplug_ui";
	
	public function start() {
		if(!PhplugPlatform::getPluginById(CorePlugin::PLUGIN_ID)->isAjaxMode() || 
			($componentId = $this->getComponentToUpdate()) != null) {
			$this->menus = array();
			$this->initWorknench();
			$this->initPerspectives();
			$this->initApplication();
			$this->initMenu();
			$this->applyStyles();
			$this->applyScripts();
			self::$workbench->draw();
		}
	}
	
	private function initMenu() {
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ui.menuConfiguration")
							->getExtensions();
		$cfg = pf\PhplugPlatform::getConfig();
		if(count($extensions)>0) {
			$ext = $extensions[0];
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$menuClass = new \ReflectionClass($el->getAttribute("menuClass"));
			$menuEntryClass = new \ReflectionClass($el->getAttribute("menuEntryClass"));
			$menuExts = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ui.menu")
							->getExtensions();
			foreach($menuExts as $menuExt) {
				$mElems = $menuExt->getConfigurationElements();
				$el = $mElems[0];
				$menu = $menuClass->newInstance(null);
				$mId = $el->getAttribute("id");
				self::$log->debug("CREATING MENU: ".$mId);
				$menu->setId($mId);
				$this->addMenuEntries($menu, $menuEntryClass);
				$this->menus[$mId] = $menu;
			}
		}
	}
	
	private function addMenuEntries(&$menu, $menuEntryClass) {
		$menuExts = pf\PhplugPlatform::getExtensionRegistry()
						->getExtensionPoint("ch.thobens.phplug.ui.menuEntry")
						->getExtensions();
		foreach($menuExts as $menuExt) {
			$mElems = $menuExt->getConfigurationElements();
			$el = $mElems[0];
			$parentId = $el->getAttribute("parentId");
			if($parentId == $menu->getId()) {
				$menuEntry = $menuEntryClass->newInstance(null);
				$menuEntry->setId($el->getAttribute("id"));
				$menuEntry->setLabel($el->getAttribute("label"));
				$this->addMenuEntries($menuEntry, $menuEntryClass);
				$menu->addMenuEntry($menuEntry);
			}
			
		}
	}
	
	public function getMenuById($id) {
		self::$log->debug("MENUS: ".serialize($this->menus));
		self::$log->debug("TRY TO GET MENU ".$id);
		return $this->menus[$id];
	}
	
	private function initApplication() {
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ui.application")
							->getExtensions();
		$cfg = pf\PhplugPlatform::getConfig();
		if(count($extensions)>0) {
			$ext = $extensions[0];
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$initialPerspective = $el->getAttribute("initialPerspective");
			$bEl = $el->getChildren();
			$bEl = $bEl["branding"];
			self::$workbench->setPerspective($initialPerspective);
			self::$workbench->setBanner($cfg->getConfigEntry(PHPLUG_CFG_PLUGINDIR).'/'.$ext->getDeclaringPlugin().'/'.$bEl->getAttribute("banner"));
			self::$workbench->setApplicationTitle($bEl->getAttribute("title"));
		}
	}
	
	public function getComponentToUpdate() {
		$componentId = null;
		if (isset($_GET["updateComponent"])) {
			$componentId = $_GET["updateComponent"];
		} else  if(isset($_POST["updateComponent"])) {
			$componentId = $_POST["updateComponent"];
		}
		return $componentId;
	}
	
	private function initWorknench() {
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ui.workbench")
							->getExtensions();
		if(count($extensions)>0) {
			$ext = $extensions[0];
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$className = $el->getAttribute("class");
			$template = $el->getAttribute("template");
			$class = new \ReflectionClass($className);
			if(!$class->implementsInterface("phplug\platform\IWorkbench")) {
				throw new pf\PhpluginException("class $className does not implement the IWorkbench interface!");
			}
			self::$workbench = new $className();
			self::$workbench->setTemplate($template);
		} else {
			self::$workbench = new ui\Workbench();
		}
		$uiProcessor = $this->initUIProcessor();
		self::$workbench->setUIProcessor($uiProcessor);
		pf\PhplugPlatform::setActiveWorkbench(self::$workbench);
	}
	
	private function applyStyles() {
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ui.style")
							->getExtensions();
		$uiProcessor = pf\PhplugPlatform::getActiveWorkbench()
							->getUIProcessor();
		$styles = array();
		$cfg = pf\PhplugPlatform::getConfig();
		$stylePrecedence = array();
		foreach($extensions as $ext) {
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$precedence = $el->getAttribute("precedence");
			$name = $el->getAttribute("name");
			if(!isset($stylePrecedence[$name]) || $precedence > $stylePrecedence[$name]) {
				$styles[] = $cfg->getConfigEntry(PHPLUG_CFG_PLUGINDIR).'/'.$ext->getDeclaringPlugin().'/'.$el->getAttribute("location");
			}
		}
		$uiProcessor->assign('styles',$styles);
	}
	
	private function applyScripts() {
		$uiProcessor = pf\PhplugPlatform::getActiveWorkbench()
							->getUIProcessor();
		$uiProcessor->assign('scripts',pf\PhplugPlatform::getPluginById(CorePlugin::PLUGIN_ID)->getScripts());
	}
	
	private function initUIProcessor() {
		$uiProcessor = null;
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ui.processor")
							->getExtensions();
		if(count($extensions)>0) {
			$ext = $extensions[0];
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$className = $el->getAttribute("class");
			$class = new \ReflectionClass($className);
			if(!$class->implementsInterface("phplug\plugins\phplug_ui\ui\UIProcessor")) {
				throw new pf\PhplugException("class $className does not implement the UIProcessor interface!");
			}
			$uiProcessor = new $className();
		}
		return $uiProcessor;
	}
	
	private function initPerspectives() {
		$epReg = pf\PhplugPlatform::getExtensionRegistry();
		$extensions = $epReg->getExtensionPoint("ch.thobens.phplug.ui.perspective")->getExtensions();
		$perspective = null;
		if(count($extensions)>0) {
			$i=0;
			foreach($extensions as $ext) {
				$elems = $ext->getConfigurationElements();
				$el = $elems[0];
				$className = $el->getAttribute("class");
				if(!class_exists($className)) {
					$className = "Perspective";
				}
				$class = new \ReflectionClass($className);
				if(!$class->implementsInterface("phplug\plugins\phplug_ui\ui\IPerspective")) {
					throw new pf\PhplugException("class $className does not implement the IPerspective interface!");
				}
				$perspective = new $className();
				$id = $el->getAttribute("id");
				if($i==0) {
					pf\PhplugPlatform::getActiveWorkbench()->setPerspective($id);
				}
				$perspective->setId($id);
				$perspective->initialize();
				pf\PhplugPlatform::getActiveWorkbench()->registerPerspective($id,$perspective);
				$i++;
			}
		}
	}
	
	public function stop() {
		
	}
	
	public static function getWorkbench() {
		return self::$workbench;
	}
}