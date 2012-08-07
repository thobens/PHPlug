<?php
namespace phplug\plugins\phplug_ui\ui\layouts;

use phplug\platform as pf,
	phplug\plugins\phplug_ui\ui;
	
/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class ListLayout extends Layout {
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/layouts/ILayout#process()
	 */
	public function process() {
		$uiProcessor = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$this->template = "ch.thobens.templates.layout.list";
		$uiProcessor->assign("composites",$this->composites);
		return $uiProcessor->process($this->template);
	}
	
	/**
	 * 
	 * @param $composite
	 * @param $x
	 * @param $y
	 * @param $width
	 * @param $height
	 * @return unknown_type
	 */
	public function addComposite(ui\IComposite $composite, $width, $height) {
		parent::addComposite($composite);
		$this->composites[] = array("width" => $width, "height" => $height, "content" => $composite->draw());
	}
	
}