<?php
namespace phplug\plugins\phplug_core\annotations;

class NestedAnnotationMatcher extends AnnotationMatcher {
	protected function process($result) {
		$builder = new AnnotationsBuilder;
		return $builder->instantiateAnnotation($result[1], $result[2]);
	}
}