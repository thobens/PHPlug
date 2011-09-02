<?php
namespace phplug\plugins\phplug_ajax_support\ui;

/**
 * 
 * Enter description here ...
 * @author adobel
 * @Server("uiUpdater")
 */
use phplug\platform\PhplugLog;

use phplug\plugins\phplug_ui\ui\CompositePool;

use phplug\plugins\phplug_ajax_support\server\HTMLServerPage;

class UIUpdateServerPage extends HTMLServerPage {
	
	public function prepareResponse() {
		$log = new PhplugLog();
		if(isset($_GET['updateComponent'])) {
			$updateComponent = $_GET['updateComponent'];
		} else if(isset($_POST['updateComponent'])) {
			$updateComponent = $_POST['updateComponent'];
		}
		$log->debug("COMPONENTS ".implode(",",array_keys(CompositePool::getInstance()->getComposites())));
		$this->responseText = CompositePool::getInstance()
		->getComposite($updateComponent)
		->draw();
		
	}
	
}