<?php
/**
 * In this file, the phplug library is tested...
 * 
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 *
 */

include("../lib/phplug.lib.php");

/***************************************************
 * Test the object un-/serialization
 */
class TestClass {
	private $testVar;
	private $testObj;
	private $testArr;
	public function __construct() {
		$this->testVar = "bla";
		$this->testObj = new TestSubClass();
		$this->testArr = array("bla" => "blubb", "foo" => new TestSubClass());
	}
	public function publicTestMethod($testArg) {
		$this->testVar = "changed";
		$this->testObj->testSubProperty = "changed too";
	}
	public function test() {
		println(var_export($this->testVar,true)."&nbsp;&nbsp;&nbsp;&nbsp;".var_export($this->testObj->testSubProperty,true));
	}
}
class TestSubClass {
	public $testSubProperty;
	public function __construct() {
		$this->testSubProperty = "blubb";
	}
}
//$obj = new TestClass();
//$obj_str = serialize_object_recursively($obj);
//println(htmlentities($obj_str));
//
//$new_obj = unserialize_object_recursively($obj_str); 
//$new_obj->publicTestMethod("");
//println($new_obj->test());
//$new_obj_str = serialize_object_recursively($new_obj);
//println(htmlentities($new_obj_str));

echo "TestView.class.php is located at: ".locate_file($_SERVER["DOCUMENT_ROOT"],"Composite.class.php");
function test_locate_file($filepath) {
	echo "TestView.class.php is located at: ".$filepath;
}
?>