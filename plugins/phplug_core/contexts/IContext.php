<?php
namespace phplug\plugins\phplug_core\contexts;

interface IContext {
	
	function initialize();
	
	function set($var, $value);
	
	function get($var);
	
}