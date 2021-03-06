<?php
namespace phplug\plugins\phplug_core\annotations;

use phplug\platform\PhplugLog;

class AnnotationsBuilder {
	private static $cache = array();
	
	private static $log;
	
	public function __construct() {
		self::$log = new PhplugLog();
	}

	public function build($targetReflection) {
		$data = $this->parse($targetReflection);
		self::$log->debug("ANNOTATION DATA: ".serialize($data));
		$annotations = array();
		foreach($data as $class => $parameters) {
			foreach($parameters as $params) {
				$annotation = $this->instantiateAnnotation($class, $params, $targetReflection);
				if($annotation !== false) {
					$annotations[get_class($annotation)][] = $annotation;
				}
			}
		}
		return new AnnotationsCollection($annotations);
	}

	public function instantiateAnnotation($class, $parameters, $targetReflection = false) {
		$class = Addendum::resolveClassName($class);
		if(is_subclass_of($class, 'phplug\plugins\phplug_core\annotations\Annotation') && 
		!Addendum::ignores($class) || 
		$class == 'phplug\plugins\phplug_core\annotations\Annotation') {
			$annotationReflection = new \ReflectionClass($class);
			return $annotationReflection->newInstance($parameters, $targetReflection);
		}
		return false;
	}

	private function parse($reflection) {
		$key = $this->createName($reflection);
		if(!isset(self::$cache[$key])) {
			$parser = new AnnotationsMatcher;
			$parser->matches($this->getDocComment($reflection), $data);
			foreach($data as $annotation => $annotationData) {
				$data[AnnotationMap::getInstance()->getClass($annotation)] = $annotationData;
				unset($data[$annotation]);
			}
			self::$cache[$key] = $data;
		}
		return self::$cache[$key];
	}

	private function createName($target) {
		if($target instanceof \ReflectionMethod) {
			return $target->getDeclaringClass()->getName().'::'.$target->getName();
		} elseif($target instanceof \ReflectionProperty) {
			return $target->getDeclaringClass()->getName().'::$'.$target->getName();
		} else {
			return $target->getName();
		}
	}

	protected function getDocComment($reflection) {
		return Addendum::getDocComment($reflection);
	}

	public static function clearCache() {
		self::$cache = array();
	}
}