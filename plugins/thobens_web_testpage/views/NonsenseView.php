<?php
namespace phplug\plugins\thobens_web_testpage\views;

use phplug\plugins\phplug_core\actions\Action;

use phplug\plugins\phplug_ui\ui\listener\EventListener;

use phplug\plugins\phplug_ui_widgets_jquery\widgets\form\controls\Input;

use phplug\plugins\phplug_ui\ui\views as v,
	phplug\plugins\phplug_ui\ui\layouts,
	phplug\plugins\phplug_ui_widgets_jquery\widgets,
	phplug\plugins\phplug_ui_widgets_jquery\widgets\form,
	phplug\plugins\phplug_ui_widgets_jquery\widgets\form\controls,
	phplug\plugins\phplug_ui_widgets\widgets\form\controls as c;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class NonsenseView extends v\ViewPart {
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/views/IViewPart#createViewPart()
	 */
	public function createViewPart($parent) {
		$layout = new layouts\GridLayout();
		$text = new widgets\Text(null,0,"Nonsense here");
		$layout->addComposite($text,0,0,1,1);
		
		$form = new form\Form(null,0);
		$form->setAction("/bla");
		
		$input = new controls\Input(null,0);
		$input->setName("intest2");
		$input->setType("text");
		$input->setValue("testValue2");
		
		$select = new controls\Select(null,0);
		$select->setName("testselect2");
		$select->setValue("testoption3");
		$select->addOption(new c\SelectOption("Tests Options 1","testoption1"));
		$select->addOption(new c\SelectOption("Tests Options 2","testoption2"));
		$select->addOption(new c\SelectOption("Tests Options 3" ,"testoption3"));
		
		$submit = new controls\Input(null,0);
		$submit->setName("foo");
		$submit->setType("submit");
		$submit->setValue("Send 3");
		
		$form->addField($input,0,0,1,1);
		$form->addField($select,0,1,1,1);
		$form->addField($submit,0,2,1,1);

		$layout->addComposite($form,0,1,1,1);
		
		$this->setLayout($layout);
	}
	
}