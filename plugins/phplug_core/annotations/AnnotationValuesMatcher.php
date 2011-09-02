<?php
namespace phplug\plugins\phplug_core\annotations;

class AnnotationValuesMatcher extends ParallelMatcher {
	protected function build() {
		$this->add(new AnnotationTopValueMatcher);
		$this->add(new AnnotationHashMatcher);
	}
}