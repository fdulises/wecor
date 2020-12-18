<?php

	namespace wecor;

	//Autocarga de clases del usuario
	spl_autoload_register(function($classname){
		$classname = explode("\\" , $classname);
		if ($classname[0] == 'wecor') {
			$filename = realpath( APP_ROOT_DIR . "/app/class/{$classname[1]}.php" );
			if( file_exists($filename) ) require_once($filename);
		}
	});

	//Activamos registro de errores
	define('DEBUG_MODE', true);
	if( !DEBUG_MODE ){
		ini_set("display_errors" , "0");
		ini_set("log_errors" , "1");
		ini_set("error_log" , "error.log.txt");
	}

	//Establecemos datos para las sesiones
	define('S_PRE',			'st_');
	define('S_ID',			S_PRE.'session_id');
	define('S_USERID',		S_PRE.'userid');
	define('S_USERNAME',	S_PRE.'username');
	define('S_USERMAIL',	S_PRE.'usermail');
	define('S_STRING',		S_PRE.'string');
	define('S_LOGING',		S_PRE.'loging');
	define('S_ROLE',		S_PRE.'role');
	session::setConfig('name', S_ID);
	session::start();

	//Establecemos zona horaria
	define('TIME_ZONE', 'America/Mexico_City');
	date_default_timezone_set(TIME_ZONE);

	//Deinimos constantes con los datos de coniguracion de la aplicacion
	define('CONF_DIR', APP_ROOT_DIR.'/app/conf');
	define('CACHE_DIR', realpath(APP_ROOT_DIR.'/../cache'));
	define('MEDIA_DIR', APP_ROOT_DIR.'/media');

	//Realizamos la coneccion con la base de datos
	require_once realpath( CONF_DIR . '/db.conf.php' );

	if( defined('DB_INSTALLED') ){
		DBConnector::connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		DB::setTablePref(DB_PREF);
	}else header('location: '.APP_ROOT."/install");

	define("THEME_DIR", 'front');
	define("THEME_URL",APP_ROOT."/".THEME_DIR);
	define("THEME_PATH",realpath(APP_ROOT_DIR."/".THEME_DIR));

	define("PLUGINS_DIR", "plugins");
	define("PLUGINS_PATH", realpath(APP_ROOT_DIR."/plugins"));
	define("PLUGINS_URL", APP_ROOT."/plugins");

	//Cargamos el paquete de idioma seleccionado
	$sitelang = 'es';
	$lang_url = THEME_DIR.'/lang/'.$sitelang.'.php';
	if( file_exists($lang_url) ) require $lang_url;
