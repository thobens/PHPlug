<?php
namespace phplug\plugins\phplug_core\annotations;

class AnnotationArrayValueMatcher extends ParallelMatcher {
	protected function build() {
		$this->add(new AnnotationValueInArrayMatcher);
		$this->add(new AnnotationPairMatcher);
	}
}