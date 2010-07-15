<?php
namespace phplug\plugins\thobens_web_testpage\views;

use phplug\plugins\phplug_ui\ui\views as v,
	phplug\plugins\phplug_ui\ui\layouts,
	phplug\plugins\phplug_ui_widgets_qx\widgets,
	phplug\plugins\phplug_ui_widgets_qx\widgets\form,
	phplug\plugins\phplug_ui_widgets_qx\widgets\form\controls,
	phplug\plugins\phplug_ui_widgets\widgets\form\controls as c;
/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class AnotherView extends v\ViewPart {
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/views/IViewPart#createViewPart()
	 */
	public function createViewPart($parent) {
		$layout = new layouts\GridLayout();
		$text = new widgets\Text(null,0,"Another Form here");
		$layout->addComposite($text,0,0,1,1);
		
		$form = new form\Form(null,0);
		$form->setAction("/bla");
		
		$area = new controls\Textarea(null,0);
		$area->setName("testarea");
		$area->setRows("6");
		$area->setCols("35");
		$area->setValue("Hello World");
		
		$select = new controls\Select(null,0);
		$select->setName("testselect");
		$select->setValue("testoption2");
		$select->addOption(new c\SelectOption("Test Option 1","testoption1"));
		$select->addOption(new c\SelectOption("Test Option 2","testoption2"));
		$select->addOption(new c\SelectOption("Test Option 3","testoption3"));
		
		$submit = new controls\Input(null,0);
		$submit->setName("bsss");
		$submit->setType("submit");
		$submit->setValue("Send 2");
		
		$form->addField($area,0,0,1,1);
		$form->addField($select,0,1,1,1);
		$form->addField($submit,0,2,1,1);
		
		$layout->addComposite($form,0,1,1,1);

		$this->setLayout($layout);
	}
	
}
?>