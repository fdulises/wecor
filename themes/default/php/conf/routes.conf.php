<?php

	/*
	* Archivo de configuracion de rutas
	* Lista con las rutas y sus controladores
	*/

	namespace wecor;

	routes::add( '/', THEME_PATH.'/index.php' );
	routes::add( 'inicio', THEME_PATH.'/index.php' );
	routes::add( 'acercade', THEME_PATH.'/acercade.php' );
	routes::add( 'blog', THEME_PATH.'/blog.php' );
	routes::add( 'contacto', THEME_PATH.'/contacto.php' );
	routes::add( 'busqueda', THEME_PATH.'/blog.php' );
	routes::add( 'code', THEME_PATH.'/code.php' );
	routes::add( 'code\/(.*)', THEME_PATH.'/codepost.php' );
