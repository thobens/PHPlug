<?php 
namespace phplug\plugins\phplug_core\contexts;

use phplug\platform\PhplugLog;

use phplug\plugins\phplug_core\CorePlugin;

use phplug\platform\PhplugPlatform;

abstract class AbstractContext implements IContext{
	
	private static $log;
	
	protected $notNew;
	
	public function __construct() {
		self::$log = new PhplugLog();
		$this->notNew = array();
	}
	
	abstract public function getContextVars();
	
	public function alreadyExists($var) {
		return in_array($var, $this->notNew);
	}
	
	protected function unserialize($ctxName, $identifier) {
		$dbHandle = PhplugPlatform::getPluginById(CorePlugin::PLUGIN_ID)->getContextDBHandle();
		$sql = 'SELECT v.name as vName, v.value as vValue FROM ctx_vars as v '
				.'INNER JOIN context as c ON c.id = v.ctx WHERE c.name = \''.$ctxName.'\' AND v.identifier = \''.$identifier.'\';';
		$result = sqlite_query($dbHandle, $sql, SQLITE_ASSOC, $error);
		if($result!==false) {
			while(($data = sqlite_fetch_array($result, SQLITE_ASSOC))!==false) {
				$value = $data['vValue'];
				$value = str_replace(PHPLUG_NULLCHAR_REPLACEMENT, "\0", $value);
				$this->set($data['vName'], unserialize($value));
			}
		} else {
			self::$log->error($error);
		}
	}
}