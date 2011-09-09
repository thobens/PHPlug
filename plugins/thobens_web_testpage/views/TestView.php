<?php
namespace phplug\plugins\thobens_web_testpage\views;

use phplug\plugins\thobens_web_testpage\test\TestAnnotationField;

use phplug\plugins\phplug_ui\ui\views as v,
	phplug\plugins\phplug_ui\ui\layouts,
	phplug\plugins\phplug_ui_widgets_jquery\widgets,
	phplug\plugins\phplug_ui_widgets_jquery\widgets\form,
	phplug\plugins\phplug_ui_widgets_jquery\widgets\form\controls,
	phplug\plugins\phplug_core\annotations as a,
	phplug\plugins\thobens_web_testpage\test;
	
use phplug\plugins\phplug_ui_widgets_jquery\widgets\form\controls\Accordion;

/**
 * 
 * @author A. Doebeli <thobens@gmail.com>
 *
 */
class TestView extends v\ViewPart {
	
	/**
	 * (non-PHPdoc)
	 * @see phplug/plugins/ch.thobens.phplug.ui/ui/views/IViewPart#createViewPart()
	 */
	public function createViewPart($parent) {
		$layout = new layouts\GridLayout();
		$text = new widgets\Text(null,0,"Hello World Text Composite");
		$layout->addComposite($text,0,0,1,1);
		
		$form = new form\Form(null,0);
		$form->setAction("/bla");
		
		$input = new controls\Input(null,0);
		$input->setName("test");
		$input->setId("test");
		$input->setType("text");
		$input->setValue("TestInput");
		
		$submit = new controls\Input(null,0);
		$submit->setName("blubb");
		$submit->setType("submit");
		$submit->setValue("Send");
		
		$form->addField($input,0,0,1,1);
		$form->addField($submit,0,1,1,1);
		
		$layout->addComposite($form,0,1,1,1);
		
		$this->setLayout($layout);
	}
}
?>