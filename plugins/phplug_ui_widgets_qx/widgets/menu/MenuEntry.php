<?
namespace phplug\plugins\phplug_ui_widgets\widgets\menu;

use phplug\plugins\phplug_ui\ui as ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class MenuEntry extends ui\Composite {
	
	private $menuEntries;
	
	public function __construct($parent,$style=0) {
		parent::__construct($parent,$style);
	}
	
	public function draw() {
		$layout = new FloatLayout();
		$contents = $layout->process();
		return $contents;
	}
}