<?php
namespace phplug\plugins\phplug_ui\ui\layouts;

use phplug\platform as pf,
	phplug\plugins\phplug_ui\ui;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class GridLayout extends Layout {
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/layouts/ILayout#process()
	 */
	public function process() {
		$uiProcessor = pf\PhplugPlatform::getActiveWorkbench()->getUIProcessor();
		$this->template = "ch.thobens.templates.layout.grid";
		$this->createMatrix();
		$uiProcessor->assign("rows",$this->composites);
		return $uiProcessor->process($this->template);
	}
	
	/**
	 * 
	 * @param $composite
	 * @param $x
	 * @param $y
	 * @param $width
	 * @param $height
	 * @return void
	 */
	public function addComposite(ui\IComposite $composite,$x,$y,$width,$height) {
		$this->composites[$y][$x] = array("width" => $width, "height" => $height, "content" => $composite->draw());
	}
	
	/**
	 * 
	 * @return void
	 */
	private function createMatrix() {
		$keys = array_keys($this->composites);
		$highest = $keys[sizeof($keys)-1];
		for($i = 0;$i <= $highest;$i++) {
			if(!isset($this->composites[$i])) {
				$this->composites[$i] = array();
			}
			$keys2 = array_keys($this->composites[$i]);
			$highest2 = $keys[sizeof($keys2)-1];
			for($j = 0;$j <= $highest2; $j++) {
				if(!isset($this->composites[$i][$j])) {
					$this->composites[$i][$j] = "&nbsp;";
				}
			}
		}
	}
}