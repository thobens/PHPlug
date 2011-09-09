<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\dialog;

use phplug\plugins\phplug_ui_widgets\widgets\form\Control;

use phplug\plugins\phplug_ui\ui\Composite;

use phplug\plugins\phplug_ui\ui\IComposite;

abstract class AbstractDialog extends Control implements IDialog {
	
	protected $title;
	
	protected $composite;
	
	protected $modal;
	
	protected $width;
	
	protected $height;
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function getComposite() {
		return $this->composite;
	}
	
	public function setComposite(IComposite $composite) {
		$this->composite = $composite;
	}
	
	public function isModal() {
		return $this->modal;
	}
	
	public function setModal($modal) {
		$this->modal = $modal;
	}
	
	public function getHeight() {
		if(!isset($this->height)) {
			return "auto";
		}
		return $this->height;	
	}
	
	public function setHeight($height) {
		$this->height = $height;
	}
	
	public function getWidth() {
		if(!isset($this->width)) {
			return "auto";
		}
		return $this->width;	
	}
	
	public function setWidth($width) {
		$this->width = $width;
	}
}