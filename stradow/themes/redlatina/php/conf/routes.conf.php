<?php

	/*
	* Archivo de configuracion de rutas
	* Lista con las rutas y sus controladores
	*/

	namespace wecor;

	routes::add( '/', THEME_PATH.'/index.php' );
	routes::add( 'index', THEME_PATH.'/index.php' );
	routes::add( 'about', THEME_PATH.'/about.php' );
	routes::add( 'contact', THEME_PATH.'/contact.php' );
	routes::add( 'cat', THEME_PATH.'/index.php' );
	routes::add( 'cat\/(.*)', THEME_PATH.'/cat.php' );
	routes::add( 'search', THEME_PATH.'/search.php' );
	routes::add( 'chanel', THEME_PATH.'/chanel.php' );
	routes::add( '(.*)', THEME_PATH.'/post.php' );
