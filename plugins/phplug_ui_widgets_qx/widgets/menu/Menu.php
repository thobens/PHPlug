<?
namespace phplug\plugins\phplug_ui_widgets\widgets\menu;

use phplug\plugins\phplug_ui_widgets\widgets\menu;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class Menu extends menu\Menu {
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
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
	
}