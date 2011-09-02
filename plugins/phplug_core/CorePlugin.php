<?php
namespace phplug\plugins\phplug_core;
use phplug\plugins\phplug_core\services\ServicesServer;

use phplug\plugins\phplug_core\annotations\ReflectionAnnotatedClass;

use phplug\plugins\phplug_core\annotations\AnnotationMap;

use phplug\plugins\phplug_core\contexts\Contexts;

use phplug\platform\PhplugLog;

use phplug\plugins\phplug_core\services\ServiceRegistry;

use phplug\platform as pf;

use phplug\plugins\phplug_core\annotations as a;

class CorePlugin extends pf\Phplugin {
	
	private $contextDB;
	
	private $dbHandle;
	
	private $annotationMap;
	
	private $scripts;
	
	const PLUGIN_ID = 'phplug_core';
	
	public function start() {
		$this->initAnnotations();
		$this->contextDB =  PHPLUG_DEFAULT_WORKING_DIR.'/context.db';
		if(!file_exists($this->contextDB)) {
			touch($this->contextDB);
			$this->initDBHandle();
			$this->initDB();
		} else {
			$this->initDBHandle();
		}
		Contexts::initContexts();
		$this->loadScripts();
	}
	
	private function initDB() {
		$sql = 'CREATE TABLE context (id INTEGER PRIMARY KEY, name VARCHAR(40));';
		$sql .= 'INSERT INTO context (id, name) VALUES (1, \'phplug_request_ctxt\');';
		$sql .= 'INSERT INTO context (id, name) VALUES (2, \'phplug_session_ctxt\');';
		$sql .= 'INSERT INTO context (id, name) VALUES (3, \'phplug_conversation_ctxt\');';
		$sql .= 'INSERT INTO context (id, name) VALUES (4, \'phplug_application_ctxt\');';
		$sql .= 'CREATE TABLE ctx_vars (name VARCHAR(200), value text, ctx INTEGER, identifier VARCHAR(200), PRIMARY KEY(name, ctx, identifier))';
		$ok = sqlite_exec($this->dbHandle, $sql, $error);
		if(!$ok) {
			self::$log->error($error);
		}
	}
	
	private function initDBHandle() {
		$ok = $this->dbHandle = sqlite_open($this->contextDB, 0666, $error);
		if(!$ok) {
			self::$log->error($error);
		}
	}
	
	private function initAnnotations() {
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.core.annotationMapping")
							->getExtensions();
		foreach($extensions as $ext) {
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$name = $el->getAttribute("name");
			$class = $el->getAttribute("class");
			a\AnnotationMap::getInstance()->register($name, $class);
		} 
	}
	
	private function loadScripts() {
		$extensions = pf\PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.core.script")
							->getExtensions();
		$scripts = array();
		$cfg = pf\PhplugPlatform::getConfig();
		$scriptPrecedence = array();
		foreach($extensions as $ext) {
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$precedence = $el->getAttribute("precedence");
			$name = $el->getAttribute("name");
			if(!isset($scriptPrecedence[$name]) || $precedence > $scriptPrecedence[$name]) {
				$scripts[] = $cfg->getConfigEntry(PHPLUG_CFG_PLUGINDIR).'/'.$ext->getDeclaringPlugin().'/'.$el->getAttribute("src");
			}
		}
		$this->scripts = $scripts;
	}
	
	public function getScripts() {
		return $this->scripts;	
	}
	
	public function stop() {
		Contexts::saveContexts();
		sqlite_close($this->dbHandle);
	}
	
	public function getContextDBHandle() {
		return $this->dbHandle;
	}
	
	public function isAjaxMode() {
		return (isset($_GET[PHPLUG_AJAX_MODE_VAR]) && intval($_GET[PHPLUG_AJAX_MODE_VAR]) == 1) || 
				(isset($_POST[PHPLUG_AJAX_MODE_VAR]) && intval($_POST[PHPLUG_AJAX_MODE_VAR]) == 1);
	}	
}
