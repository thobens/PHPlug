<?php
namespace phplug\platform;
/**
 * This is the core of phplug. It loads the configuration and the depending
 * plugins, so they can be used everywhere in the platform.
 * 
 * date: 2010-01-16
 *  
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 */
class PhplugPlatform implements IPhplugPlatform {
	
	/**
	 * Arrray containing the plugin objects that are defined in
	 * the platform. The keys are the plugin id's
	 * 
	 * @var array
	 */
	private static $plugins;
	
	/**
	 * List of plugin class names. Used to check if a class
	 * is already loaded. The keys are the plugin id's
	 * 
	 * @var array
	 */
	private $pluginClasses;
	
	/**
	 * List of plugin Metadata. The keys are the plugin id's
	 * 
	 * @var array
	 */
	private $pluginMetadata;
	
	/**
	 * Configuration object for the platform
	 * 
	 * @var IPphplugConfig
	 */
	private static $config;
	
	/**
	 * Indicates if the platform is prepared. This is the case,
	 * if the plugin xml's are read and the platform is ready to
	 * create the plugin objects.
	 * 
	 * @var boolean
	 */
	private $isPrepared;
	
	/**
	 * Indictes if the patform is running. This is the case,
	 * if the plugin objects are created and started.
	 * 
	 * @var boolean
	 */
	private $isRunning;
	
	/**
	 * The extension regisrty. It holds the extensions that are
	 * defined in each plugin.
	 * 
	 * @var IPhpluginExtensionRegistry
	 */
	private static $extensionRegistry;
	
	/**
	 * The logger...
	 * 
	 * @var PhplugLog
	 */
	private static $log;
	
	/**
	 * The Wokspace the user currently uses
	 * 
	 * @var IPhplugWorkspace
	 */
	private static $workspace;
	
	/**
	 * The Worbench that is registered to this platform
	 * @var IWorkbench
	 */
	private static $workbench;
	
	/**
	 * The instance of the Platform for the singleton pattern...
	 * 
	 * @var IPhplugPlatform
	 * @noserialize
	 */
	private static $INSTANCE;

	
	
	/**
	 * Initializes the platform
	 */
	private function __construct() {
		self::$plugins = array();
		$this->pluginMetadata = array();
		$this->pluginClasses = array();
		$this->isPrepared = false;
		$this->isRunning = false;
		self::$log = new PhplugLog();
		self::$log->info("starting Phplug core...");
		self::$extensionRegistry = new PhpluginExtensionRegistry();
	}
	
	/**
	 * Returns the singleton instance
	 * 
	 * @return IPhplugPlatform
	 */
	public static function getSingleton() {
		if(!isset(self::$INSTANCE)) {
//			if(!isset($_SESSION[PHPLUG_PLATFORM_STATE_VAR])) {
				self::$INSTANCE = new self;
//				self::$log->debug("No session cache available, built new Platform...");
//			} else {
//				self::$INSTANCE = unserialize_object_recursively($_SESSION[PHPLUG_PLATFORM_STATE_VAR]);
//				self::$log->debug("Loaded Platform from session cache...");
//			}
		}
		return self::$INSTANCE;
	}
	
	/**
	 * @see phplug/inc/IPhplugPlatform#loadPlatform()
	 */
	public function loadPlatform() {
		if($this->loadPlugins()) {
			$this->registerAllExtensionPoints();
			$this->run();
			return true;
		}
		return false;
	}
	
	/**
	 * Prepares the plugins. This means it reads plugin.xml files from all
	 * plugins that are defined in the platform.xml and marked as 'active'
	 * 
	 * 
	 * @return unknown_type
	 */
	public function preparePlugins() {
		if(!$this->isPrepared) {
			$phplug_cfg = PhplugPlatform::getConfig();
			$pdef = $phplug_cfg->getConfigEntry(PHPLUG_CFG_ROOTDIR)."/".PHPLUG_PLATFORM_DEFINITION;
			$xml = simplexml_load_file($pdef);
			$pluginNodes = $xml->xpath("/platform/plugin[@active='true']");
			$includePaths = array();
			
			// initialize each plugin's metadata so all required files can be included
			foreach($pluginNodes as $pNode) {
				$attrs = $pNode->attributes();
				$id = (string)$attrs["id"];
				
				//get the plugin metadata from plugin.xml and add it to the cache, if necessary
				$md = $this->loadPluginMetadata($id);
				if(!array_key_exists($id,self::$plugins)) {
					$class = $md->class;
					if(!array_key_exists($class, $this->pluginClasses)) {
						self::$plugins[$id] = $md;
						$this->pluginMetadata[$id] = $md;
						$this->pluginClasses[$class] = $id;
					} else {
						self::$log->error("the class $class already exists! plugin will not be added!");
					}
				} else {
					self::$log->warn("plugin already loaded");
				}
			}
			$this->isPrepared = true;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Checks, if all dependencies of a plugin are satisfied. If so, true will be returned, 
	 * otherwise the return value will be an array containing the missing dependencies.
	 * If no dependencies are specified, true will be returned.
	 * 
	 * @param $md Plugin Metadata
	 * @return mixed	an array containing the missing dependencies, if there are any. Otherwise true
	 */
	private function resolveDependencies(IPhpluginMetadata $md) {
		if(!is_array($md->dependencies)) {
			// this means that we have no dependencies
			return true;
		}
		$missingDependencies = array();
		foreach($md->dependencies as $dep) {
			$attributes = $dep->attributes();
			$pid = (string)$attributes["id"];
			if(!array_key_exists($pid,$this->pluginMetadata)) {
				$missingDependencies[] = $pid;
			}
		}
		return (count($missingDependencies)>0?$missingDependencies:true);
	}
	
	/**
	 * Returns all necessary include paths of a plugin. This includes the plugin class itself
	 * and all other files contained in the folders that are defined as to export in the
	 * plugin.xml file. 
	 * Note: Only files with an extension defined in the config file will be included.
	 * 
	 * @param $md
	 * @return unknown_type
	 */
	private function getPluginIncludePaths(IPhpluginMetadata $md) {
		$phplug_cfg = PhplugPlatform::getConfig();
		$path = $phplug_cfg->getConfigEntry(PHPLUG_CFG_PLUGINDIR)."/".$md->id."/";
		$pathArray = array();
//		$pathArray[0] = $path.$md->classfile;
		$extensions = explode(",",$phplug_cfg->getConfigEntry(PHPLUG_CFG_PHP_EXTENSIONS));
		foreach($md->exports as $export) {
			$a = $export->attributes();
			$exportPath = $path.$a["folder"];
			if(is_dir($exportPath)) {
				$files = get_file_list($exportPath);
				foreach($files as $file) {
					$fileNameParts = explode(".",$file);
					if(!is_dir($file)&&in_array($fileNameParts[count($fileNameParts)-1],$extensions)) {
						$pathArray[] = $exportPath."/".$file;
					}
				}
			}
		}
		return $pathArray;
	}
	
	/**
	 * Loads all plugins available in this platform instance.
	 * returns false, if an error occurs, otherwise true
	 * 
	 * @return boolean
	 */
	private function loadPlugins() {
		$isOk = true;
		if($this->isPrepared && !$this->isRunning) {
			foreach(self::$plugins as $id => $md) {
				$plugin = $this->loadPlugin($id,$md);
				if($plugin===false) {
					$isOk = false;
				}
				self::$plugins[$id] = $plugin;
 			}
		}
		$this->isRunning = true;
		return $isOk;
	}
	
	/**
	 * Instanciates a plugin and returns it. Returns false, if there are unresolved dependencies
	 * 
	 * @param $id
	 * @param $class
	 * @return mixed
	 */
	private function loadPlugin($id, IPhpluginMetadata $md) {
		$class = $md->class;
		$class = $class;
		$resolvedDependencies = $this->resolveDependencies($md);
		if($resolvedDependencies===true) {
//			if(class_exists($class)) {
				$plugin = new $class($id);
				$plugin->setMetadata($md);
				return $plugin;
//			}
		} else {
			self::$log->error("Unresolved dependencies in ".$md->id.", missing: ".implode(", ",$resolvedDependencies));
		}
		self::$log->error("Failed to load plugin: $id");
		return false;
	}
	
	/**
	 * Runs all plugins in the appropriate order
	 */
	private function run() {
		foreach(self::$plugins as $plugin) {
			$plugin->start();
		}
	}
	
	/**
	 * Loads the Metadata of a plugin by it's id. The config will be rad from the
	 * plugin.xml file. The metadata will be returned as an object implementing IPhpluginMetadata
	 * 
	 * @param $id string	the id of the plugin, whose metadata should be loaded
	 * @return IPhpluginMetadata	the metadata object of the plugin
	 */
	private function loadPluginMetadata($id) {
		$phplug_cfg = PhplugPlatform::getConfig();
		$xml = simplexml_load_file($phplug_cfg->getConfigEntry(PHPLUG_CFG_PLUGINDIR)."/".$id."/plugin.xml");
		$md = new PhpluginMetadata();
		$v = $xml->xpath("/plugin/@class");
		$md->class = (string)$v[0];
		$md->dependencies = $xml->xpath("/plugin/dependencies/dependency");
		$v = $xml->xpath("/plugin/@classfile");
		$md->classfile = (string)$v[0];
		$md->exports = $xml->xpath("/plugin/exports/export");
		$md->extensions = $xml->xpath("/plugin/extensions");
		$md->extensionPoints = $xml->xpath("/plugin/extensionPoints/extensionPoint");
		$md->id = $id;
		
		return $md;
	}
	
	/**
	 * Registers all extensionPoints defined in the platform
	 * 
	 * @return void
	 */
	private function registerAllExtensionPoints() {
		foreach(self::getPlugins() as $plugin) {
			$this->registerExtensionPoints($plugin->getMetadata()->extensionPoints, $plugin->getId());
		}
	}
	
	/**
	 * Registers the given extensionPoints
	 * 
	 * @param $points SimpleXMLElement
	 * @return void
	 */
	private function registerExtensionPoints($points, $pluginId) {
		foreach($points as $point) {
			$attrs = $point->attributes();
			$expt = new PhpluginExtensionPoint((string)$attrs["id"],
										(string)$attrs["name"],
										(string)$attrs["schema"]);
			self::$extensionRegistry->registerExtensionPoint($expt, $pluginId);
		}
	}
	
	/**
	 * Creates a new PhplugConfig object, if such one never was instanciated
	 * 
	 * @return IPhplugConfig	Configuration object
	 */
	public static function getConfig() {
		if(!PhplugPlatform::$config) {
			PhplugPlatform::$config = new PhplugConfig();
		}
		return PhplugPlatform::$config;
	}
	
	/**
	 * Returns the workspace object
	 * 
	 * @return IPhplugWorkspace
	 */
	public static function getWorkspace() {
		if(!PhplugPlatform::$workspace) {
			PhplugPlatform::$workspace = new PhplugWorkspace();
		}
		return PhplugPlatform::$workspace;
	}
	
	/**
	 * Returns the extension registry
	 * 
	 * @return IPhpluginExtensionRegistry
	 */
	public static function getExtensionRegistry() {
		return self::$extensionRegistry;
	}
	
	public static function setActiveWorkbench(IWorkbench $workbench) {
		if(!isset(self::$workbench)) {
			self::$workbench = $workbench;
		} else {
			self::$log->warn("The workbench can only be set once! Ignoring PhplugPlatform::setActiveWorkbench()...");
		}
	}
	
	public static function getActiveWorkbench() {
		return self::$workbench;
	}
	
	/**
	 * Returns an array with the loaded plugin objects
	 * 
	 * @return array
	 */
	public static function getPlugins() {
		return self::$plugins;
	}
	
	/**
	 * Returns the Plugin's activator based on it's id
	 * 
	 * @param IPhplugin $id
	 */
	public static function getPluginById($id) {
		return self::$plugins[$id];
	}
	
	/**
	 * Saves the state of the whole Platform as a serialized string in the Session
	 * 
	 * @return unknown_type
	 */
	private function saveState() {
		$state = var_export($this,true);
		$_SESSION[PHPLUG_PLATFORM_STATE_VAR] = $state;
	}
	
	/**
	 * 
	 * @return unknown_type
	 */
	private function loadState() {
		self::__set_state($SESSION[PHPLUG_PLATFORM_STATE_VAR]);
	}
	
	public function getPluginClasses() {
		return $this->pluginClasses;
	}
	
	
	/********************************************************************
	 * AND NOW LET'S ADD SOME MAGIC FUNCTIONALITY, UUUUHHH **************
	 ********************************************************************/
	
	/**
	 * Logs if a non-existent method is called on this object
	 * 
	 * @param $method
	 * @param $params
	 */
	public function __call($method,$params) {
		$backtrace = debug_backtrace();
		self::$log->error("calling undefined method $method... in ".$backtrace[1]["file"]." at line ".$backtrace[1]["line"]);
	}
	
	/**
	 * Serializes the platform and saves it a string in the session
	 */
	public function __destruct() {
		foreach(self::$plugins as $plugin) {
			$plugin->stop();
		}
		$this->saveState();
	}
	
}