<?php

	/*
	* Archivo de configuracion de rutas
	* Lista con las rutas y sus controladores
	*/

	namespace wecor;

	/*routes::add( '/', 							'index');
	routes::add( 'index', 						'index');*/

	routes::add( 'usersingin', [__NAMESPACE__.'\user', 'singin'] );
	routes::add( 'userregister', [__NAMESPACE__.'\user', 'singup'] );
	routes::add( 'logout', [__NAMESPACE__.'\user', 'logout'] );
	routes::add( 'updateacount', [__NAMESPACE__.'\user', 'updateacount'] );
	routes::add( function( $url ){
		$data = [];
		$result = post::get([
			'slug' => $url, 'columns' => [ 'p.id', 'p.type', 'p.title', 'p.slug', 'p.descrip', 'p.updated', 'p.cover', 'p.coverlocal', 'p.content' ],
		]);
		if( $result ){
			$data['controller'] = $result['type'];
			$data['params'] = $result;
		}
		return $data;
	} );
