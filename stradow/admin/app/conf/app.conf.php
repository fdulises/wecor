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
	session::setConfig('name', S_ID);
	session::start();

	//Establecemos zona horaria
	define('TIME_ZONE', 'America/Mexico_City');
	date_default_timezone_set(TIME_ZONE);

	//Deinimos constantes con los datos de coniguracion de la aplicacion
	define('CONF_DIR', realpath(APP_ROOT_DIR.'/../app/conf'));
	define('CACHE_DIR', realpath(APP_ROOT_DIR.'/../cache'));
	define('MEDIA_DIR', realpath(APP_ROOT_DIR.'/../media'));
	define('PLUGINS_DIR', realpath(APP_ROOT_DIR.'/../plugins'));
	define('THEMES_DIR', 'themes');
	define('THEMES_PATH', realpath(APP_ROOT_DIR.'/../'.THEMES_DIR));

	//Realizamos la coneccion con la base de datos
	require_once realpath( CONF_DIR . '/db.conf.php' );
	DBConnector::connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	DB::setTablePref(DB_PREF);

	//Obtenemos datos de configuracion por defecto de la base de datos
	config::get();
