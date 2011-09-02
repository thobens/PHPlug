<?php
/**
 * phplug.lib.php
 * 
 * The phplug library. Some common used functions are defined here...
 * 
 * date: 2010-01-10
 *  
 * @see LICENSE.txt
 * @version 0.1
 * @author A. Doebeli <thobens@gmail.com>
 */


/**
 * Executes chmod on all files within a directory. If $path is not a directory,
 * it will be chmodded as a file.
 * 
 * @param $path	string		the path to chmod recursively
 * @param $filemode			the mode to set on the files
 * @return boolean	false, if a file cannot be chmodded. In that case,
 * 					the function will abort immediately. Otherwise true is returned.
 */
function chmod_recursive($path, $filemode) {
	if(!is_dir($path)) {
		return chmod($path, $filemode);
	}
	$dh = opendir($path);
	while(($file=readdir($dh))!==false) {
		if($file!="." && $file!="..") {
			$fullpath = $path."/".$file;
			if(!is_dir($fullpath) && !chmod($fullpath,$filemode)) {
				return false;
			} elseif(!chmod_recursive($fullpath,$filemode)) {
				return false;
			}
		}
	}
	closedir($dh);
	return chmod($path,$filemode);
}

/**
 * Deletes a directory.
 * 
 * @param $dir	string	the directory to delete
 * @return boolean	false, if $dir is not a directory, otherwise true.
 */
function delete_directory($dir) {
	if(!is_dir($dir)) {
		return false;
	}
	$dh=opendir($dir);
	while($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$next = $dir."/".$file;
			if(!is_dir($next)) {
				unlink($next);
			} else {
				delete_directory($next);
			}
		}
	}
	closedir($dh);
	rmdir($dir);
	return true;
}

/**
 * Returns a list of all files in directory (non recursive)
 * 
 * @param $dir	string	The directory to delete
 * @return array	The list with the filenames contained in this directory.
 * 					If $dir is not a directory, false will be returned.
 */
function get_file_list($dir) {
	if(!is_dir($dir)) {
		return false;
	}
	$dh=opendir($dir);
	$list = array();
	while($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$list[] = $file;
		}
	}
	closedir($dh);
	return $list;
}

/**
 * prints out an array with error messages
 * 
 * @param $msgArray	array	the array containing the error messages to be printed
 */
function print_phplug_error($msgArray) {
	for($i=0;$i<count($msgArray);$i++) {
		echo $msgArray[$i]."<br />";
	}
}

/**
 * 
 * @param $var
 * @param $default
 * @return unknown_type
 */
function default_if_null(&$var, $default) {
	if($var==null) {
		$var = $default;
	}
}

/**
 * 
 * @param $var
 * @param $default
 * @param $trim
 * @return unknown_type
 */
function default_if_empty(&$var, $default, $trim=false) {
	if($trim) {
		if(trim($var)=="") {
			$var = $default;
		}
	} else {
		if($var=="") {
			$var = $default;
		}
	}
}

/**
 * Serializes an object recursively and returns an xml string
 * 
 * @param $obj
 * @return string
 */
function serialize_object_recursively($obj) {
	if(!is_object($obj)) {
		return false;
	}
	$refl = new ReflectionObject($obj);
	$xml = "<o class=\"".$refl->getName()."\">";
	$props = $refl->getProperties();
	foreach($props as $property) {
		$property->setAccessible(true);
		$pVal = $property->getValue($obj);
		$pClass = "";
		$pDoc = $property->getDocComment();
		if(strpos($pDoc,"@noserialize")===false) {
			if(is_object($pVal)) {
				$xml .= "<p name=\"".$property->getName()."\" type=\"object\">".serialize_object_recursively($pVal)."</p>";
			} elseif(is_array($property->getValue($obj))) {
				$xml .= "<p name=\"".$property->getName()."\"  type=\"array\">".serialize_array_recursively($pVal)."</p>";
			}else {
				$xml .= "<p name=\"".$property->getName()."\"  type=\"string\" value=\"".base64_encode($pVal)."\" />";
			}
		}
	}
	$xml .= "</o>";
	return $xml;
}

/**
 * 
 * @param $arr
 * @return unknown_type
 */
function serialize_array_recursively($arr) {
	if(!is_array($arr)) {
		return false;
	}
	$xml = "<a>";
	foreach($arr as $key => $value) {
		if(is_array($value)) {
			$xml .= "<e key=\"$key\" type=\"array\">".serialize_array_recursively($value)."</e>";
		} elseif(is_object($value)) {
			$xml .= "<e key=\"$key\" type=\"object\">".serialize_object_recursively($value)."</e>";
		} else {
			$xml .= "<e key=\"$key\" type=\"string\" value=\"".base64_encode($value)."\" />";
		}
	}
	$xml .= "</a>";
	return $xml;
}

/**
 * Unserializes an xml String to an oject

 * @param $xml_str
 * @return object
 */
function unserialize_object_recursively($xml_str) {
	$xml = simplexml_load_string($xml_str);
	$attrs = $xml->attributes();
	$class = (string)$attrs["class"];
	$rClass = new ReflectionClass($class);
	$constructor = $rClass->getConstructor();
	if($constructor->isPublic()) {
		$obj = $rClass->newInstance();
	} else {
		$method = $rClass->getMethod("getSingleton");
		$obj = $method->invoke(null);
		unset($method);
	}
	unset($constructor);
 	foreach($xml->children() as $child) {
		$c_attrs = $child->attributes();
		$type = (string)$c_attrs["type"];
		$pName = (string)$c_attrs["name"];
		$unknownType = false;
		switch($type) {
			case "object":
				$obj_xml = $child->children();
				$obj_xml = $obj_xml[0];
				$value = unserialize_object_recursively($obj_xml->asXML());
				if($value == null) {
					continue;
				}
				break;
			case "array":
				$value = unserialize_array_recursively($obj_xml->asXML());
				break;
			case "string":
				$value = base64_decode((string)$c_attrs["value"]);
				break;
			default:
				$unknownType = true;
				break;
		}
		if(!$unknownType) {
			$property = new ReflectionProperty($class,$pName);
			$property->setAccessible(true);
			$property->setValue($obj,$value);
			unset($property);
		}
	}
	unset($rClass);
	return $obj;
}

/**
 * 
 * @param $xml_str
 * @return unknown_type
 */
function unserialize_array_recursively($xml_str) {
	$xml = simplexml_load_string($xml_str);
	$arr = array();
	foreach($xml->children() as $child) {
		$c_attrs = $child->attributes();
		$key = (string)$c_attrs["key"];
		$type = (string)$c_attrs["type"];
		$unknownType = false;
		switch($type) {
			case "array":
				$arr_el = $child->chidren();
				$arr_el = $obj_el[0];
				$value = unserialize_array_recursively($arr_el->asXML());
				break;
			case "object":
				$obj_el = $child->chidren();
				$obj_el = $arr_el[0];
				$value = unserialize_object_recursively($obj_el->asXML());
				break;
			case "string":
				$value = (string)$c_attrs["value"];
				break;
			default:
				$unknownType = true;
				break;
		}
		if(!$unknownType) {
			$arr[$key] = $value;
		}
	}
	return $arr;
}

/**
 * locates a file in a directory. it checks the directory recursively and calls
 * the $callback function if a file is founded
 * 
 * @param $path
 * @param $filename
 * @param $callback
 * @return unknown_type
 */
function locate_file($path, $filename, $callback="") {
  $path = rtrim(str_replace("\\", "/", $path), '/') . '/';
  $matches = array();
  $entries = array();
  $dir = dir($path);
  while (false !== ($entry = $dir->read())) {
    $entries[] = $entry;
  }
  $dir->close(); 
  foreach ($entries as $entry) {
    $fullname = $path . $entry;
    if ($entry != '.' && $entry != '..' && is_dir($fullname)) {
  		$result = locate_file($fullname, $filename, $callback);
  		if($result) {
  			return $result;
  		}
    } else if (is_file($fullname) && $filename == $entry) {
    	if($callback!="") {
    		call_user_func($callback,$fullname);
    	} else {
      		return $fullname;
    	}
    }
  }
}



/**
 * 
 * @param $str
 * @return unknown_type
 */
function println($str) {
	echo $str."<br />";
}

/**
  * Generates an UUID
  * 
  * @author     Anis uddin Ahmad <admin@ajaxray.com>
  * @param      string  an optional prefix
  * @return     string  the formatted uuid
  */
function uuid($prefix = ''){
    $chars = md5(uniqid(mt_rand(), true));
    $uuid  = substr($chars,0,8) . '-';
    $uuid .= substr($chars,8,4) . '-';
    $uuid .= substr($chars,12,4) . '-';
    $uuid .= substr($chars,16,4) . '-';
    $uuid .= substr($chars,20,12);
    return $prefix . $uuid;
}

?>