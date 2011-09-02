<?php
namespace phplug\plugins\phplug_ui_processor\uiprocessor;

use phplug\platform as pf;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class TemplateStore {
	
	/**
	 * 
	 * @var unknown_type
	 */
	private static $INSTANCE;
	
	/**
	 * Array to store the templates
	 * 
	 * @var unknown_type
	 */
	private $templates;
	
	/**
	 * 
	 * @var PhplugLog
	 */
	private static $log;
	
	
	/**
	 * Initialize...
	 */
	private function __construct() {
		self::$log = new pf\PhplugLog();
		$this->templates = array();
		$epReg = pf\PhplugPlatform::getExtensionRegistry();
		$extensions = $epReg->getExtensionPoint("ch.thobens.phplug.ui.processor.template")->getExtensions();
		foreach($extensions as $extension) {
			$elems = $extension->getConfigurationElements();
			$el = $elems[0];
			$path = $el->getAttribute("path");
			$id = $el->getAttribute("id");
			$this->templates[$id] = $path;
		}
	}
	
	/**
	 * Returns the singleton instance
	 * 
	 * @return TemplateStore
	 */
	public static function getSingleton() {
		if(!isset(self::$INSTANCE)) {
			self::$INSTANCE = new self;
		}
		return self::$INSTANCE;
	}
	
	/**
	 * Adds a template to the store
	 * 
	 * @param $name
	 * @param $path
	 * @return void
	 */
	public function addTemplate($name, $path) {
		$this->templates[$name] = $path;
	}
	
	/**
	 * Returns a path to a template
	 * 
	 * @param $name
	 * @return string
	 */
	public function getTemplate($name) {
		return $this->templates[$name];	
	}
	
}