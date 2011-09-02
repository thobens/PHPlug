<?php
namespace phplug\plugins\phplug_core\contexts;

use phplug\plugins\phplug_core\CorePlugin;

use phplug\platform\PhplugPlatform;

use phplug\platform\PhplugLog;

class Contexts {
	
	const SESSION_CONTEXT = 'phplug_session_ctxt';
	
	const CONVERSATION_CONTEXT = 'phplug_conversation_ctxt';
	
	const REQUEST_CONTEXT = 'phplug_request_ctxt';
	
	const APPLICATION_CONTEXT = 'phplug_application_ctxt';
	
	const SP_CONV = 'phplug_conversations';
	
	const APP_CTX_IDENTIFIER = 'application';
	
	private static $contexts;
	
	private static $notDBRelevant;
	
	private static $log;
	
	public static function initContexts() {
		self::$log = new PhplugLog();
		self::$contexts = array();
		self::$notDBRelevant = array();
		self::$notDBRelevant[] = self::REQUEST_CONTEXT;
		$ctx = new SessionContext();
		$ctx->initialize();
		self::$contexts[self::SESSION_CONTEXT][session_id()] = $ctx;
		$ctx = new RequestContext();
		$ctx->initialize();
		self::$contexts[self::REQUEST_CONTEXT][0] = $ctx;
		$ctx = new ApplicationContext();
		$ctx->initialize();
		self::$contexts[self::APPLICATION_CONTEXT][self::APP_CTX_IDENTIFIER] = $ctx;
		if(!isset($_SESSION[self::SP_CONV])) {
			$_SESSION[self::SP_CONV] = array();
		}
		self::$contexts[self::CONVERSATION_CONTEXT] = array();
		foreach($_SESSION[self::SP_CONV] as $cid) {
			$ctx = new ConversationContext();
			$ctx->setId($cid);
			$ctx->initialize();
			self::$contexts[self::CONVERSATION_CONTEXT][$cid] = $ctx;
		}
	}
	
	public static function lookup($var) {
		foreach(self::$contexts as $ctxName => $ctxList) {
			foreach($ctxList as $ctxIdentifier => $ctx) {
				$value = $ctx->get($var);
				if($value) {
					return $value;
				}
			}
		}
	}
	
	public static function getApplicationContext() {
		return self::$contexts[self::APPLICATION_CONTEXT][self::APP_CTX_IDENTIFIER];
	}
	
	public static function getConversationContext($conversationId) {
		return self::$contexts[self::CONVERSATION_CONTEXT][$conversationId];
	}
	
	public static function getSessionContext() {
		return self::$contexts[self::SESSION_CONTEXT][session_id()];
	}
	
	public static function getRequestContext() {
		return self::$contexts[self::REQUEST_CONTEXT][0];
	}
	
	/**
	 * 
	 * returns string id of the conversation started
	 */
	public function startConversation($conversationId) {
		if(!isset(self::$contexts[self::CONVERSATION_CONTEXT][$conversationId])) {
			self::$contexts[self::CONVERSATION_CONTEXT][$conversationId] = array();
		}
		$conversation = new ConversationContext();
		$conversation->setId($conversationid);
		self::$contexts[self::CONVERSATION_CONTEXT][$conversationId] = $conversation;
	}
	
	public static function saveContexts() {
		$dbHandle = PhplugPlatform::getPluginById(CorePlugin::PLUGIN_ID)->getContextDBHandle();
		self::$log->info('saving contexts...');
		foreach(self::$contexts as $ctxName => $ctxList) {
			if(!in_array($ctxName, self::$notDBRelevant)) {
				foreach($ctxList as $ctxIdentifier => $ctx) {
					$vars = $ctx->getContextVars();
					$sql = '';
					foreach($vars as $name => $value) {
						$value = serialize($value);
						$value = str_replace("\0", PHPLUG_NULLCHAR_REPLACEMENT, $value);
						if($ctx->alreadyExists($name)) {
							$sql .= 'UPDATE ctx_vars SET value = \''.$value.'\' WHERE '
										.'name = \''.$name.'\' AND '
										.'ctx = (SELECT id FROM context WHERE name = \''.$ctxName.'\') AND '
										.'identifier = \''.$ctxIdentifier.'\';';
						} else {
							$sql .= 'INSERT INTO ctx_vars (name, value, ctx, identifier) VALUES(\''
										.$name.'\',\''
										.$value.'\','
										.'(SELECT id FROM context WHERE name = \''.$ctxName.'\'),\''
										.$ctxIdentifier.'\');';
						}
					}
					if($sql != '') {
						$ok = sqlite_exec($dbHandle, $sql, $error);
						if(!$ok) {
							self::$log->error($error);
						}
					}
				}
			}
		}
	}
		
}