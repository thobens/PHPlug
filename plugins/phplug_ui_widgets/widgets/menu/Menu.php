<?
namespace phplug\plugins\phplug_ui_widgets\widgets\menu;

use phplug\plugins\phplug_ui\ui as ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Menu extends ui\Composite {
	
	private $menus;
	
	private $menuCreated;
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
		$this->menus = array();
		$this->menuCreated = false;
	}
	
	public function draw() {
		if($this->menuCreated) {
			$layout = new FloatLayout();
			foreach($this->menus as $menu) {
				$layout->addComposite($menu,"70px","20px");
			}
			$contents = $layout->process();
		} else {
			$log = new PhplugLog();
			$log->warn("Menu was not created before... Cannot draw menu!");
		}
		return $contents;
	}
	
	public function createMenu($name) {
		$extensions = PhplugPlatform::getExtensionRegistry()
							->getExtensionPoint("ch.thobens.phplug.ui.menu.entry")
							->getExtensions();
		foreach($extensions as $ext) {
			$elems = $ext->getConfigurationElements();
			$el = $elems[0];
			$menuName = $el->getAttribute("menuName");
			if($menuName==$name) {
				$this->menus[] = new MenuEntry(null,0);
			}
		} 
	}
}