<?php
	namespace wecor;

	//Autocarga de clases del plugin
	spl_autoload_register(function($classname){
		$classname = explode("\\" , $classname);
		if ($classname[0] == 'wecor') {
			$filename = dirname(__FILE__)."/class/{$classname[1]}.php";
			if( file_exists($filename) ) require_once($filename);
		}
	});
