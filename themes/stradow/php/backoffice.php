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

	backOffice::addSection([
		'id' => 'code',
		'title' => 'Documentación',
		'route' => 'code',
		'controller' => dirname(__FILE__).'/sec/code.sec.php',
		'mainmenu' => true,
		'url' => APP_ROOT.'/code',
		'icon' => '<span class="icon-file-o"></span>',
	]);
	backOffice::addSection([
		'id' => 'codeCreate',
		'title' => 'Agregar entrada',
		'route' => 'code\/create',
		'controller' => dirname(__FILE__).'/sec/code.create.sec.php',
		'mainmenu' => true,
		'url' => APP_ROOT.'/code/create',
		'parent' => 'code',
	]);
	backOffice::addSection([
		'id' => 'codeUpdate',
		'title' => 'Editar entrada',
		'route' => 'code\/update\/(\d+)',
		'controller' => dirname(__FILE__).'/sec/code.update.sec.php',
	]);

	$GLOBALS['editorsections'][] = dirname(__FILE__).'/sec/code.sec.php';
	$GLOBALS['editorsections'][] = dirname(__FILE__).'/sec/code.create.sec.php';
	$GLOBALS['editorsections'][] = dirname(__FILE__).'/sec/code.update.sec.php';
