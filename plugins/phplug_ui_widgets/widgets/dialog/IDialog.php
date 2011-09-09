<?php
namespace phplug\plugins\phplug_ui_widgets\widgets\dialog;

use phplug\plugins\phplug_ui\ui\IComposite;

interface IDialog extends IComposite {
	
	public function getTitle();
	
	public function setTitle($title);
	
	public function setComposite(IComposite $composite);
	
	public function getComposite();
	
	public function setModal($modal);
	
	public function isModal();
}