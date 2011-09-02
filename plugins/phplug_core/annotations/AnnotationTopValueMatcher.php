<?php
namespace phplug\plugins\phplug_core\annotations;

class AnnotationTopValueMatcher extends AnnotationValueMatcher {
	protected function process($value) {
		return array('value' => $value);
	}
}