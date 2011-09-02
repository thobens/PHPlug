<?php
namespace phplug\plugins\phplug_core\annotations;

class AnnotationArrayValuesMatcher extends ParallelMatcher {
	protected function build() {
		$this->add(new AnnotationArrayValueMatcher);
		$this->add(new AnnotationMoreValuesMatcher);
	}
}