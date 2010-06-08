<?php
namespace phplug\plugins\phplug_ui;
use phplug\platform as pf,
	phplug\plugins\phplug_ui\ui;
class UIPlugin extends pf\Phplugin {
	
	/**
	 * 
	 * @var IWorkbench
	 */
	private static $workbench;
	
	public function start() {
		$this->initWorknench();
		$this->initPerspectives();
		self::$workbench->draw();
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