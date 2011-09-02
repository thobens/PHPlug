<?php
namespace phplug\plugins\phplug_core\annotations;

class AnnotationStringMatcher extends ParallelMatcher {
	protected function build() {
		$this->add(new AnnotationSingleQuotedStringMatcher);
		$this->add(new AnnotationDoubleQuotedStringMatcher);
	}
}