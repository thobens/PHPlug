<?php
namespace phplug\plugins\phplug_core\annotations;

class AnnotationValueInArrayMatcher extends AnnotationValueMatcher {
	public function process($value) {
		return array($value);
	}
}