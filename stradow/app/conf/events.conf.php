<?php

	namespace wecor;

	//Cargamos los plugins
	function pluginsLoad(){
		plugins::insert();
		themes::insert();
	}
	event::add('beforeLoadSec', 'pluginsLoad', 11);

	//Definimos metatags por defecto
	function metatgsGenerator(){
		site::setMeta( 'lang', 'es' );
		site::setMeta( 'charset', 'utf-8' );
		site::setMeta( 'generator', 'Stradow' );
		site::setMeta( 'viewport', 'width=device-width, initial-scale=1' );
		site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );
		site::setMeta( 'title', config::get('site_title') );
		site::setMeta( 'description', config::get('site_descrip') );
		site::setMeta( 'robots', 'index' );
		site::setMeta( 'icon', config::get('site_url').'/favicon.ico' );
	}
	event::add('afterLoadSec', 'metatgsGenerator', 11);

	//Contadores de usuarios
	function siteUserIncrement($data){
		if( isset($data['state']) ){
			if( $data['state'] == 1 )
				DB::update('site')->set('total_user = total_user+1')->send();
		}
	}
	event::add('userCreated', 'siteUserIncrement', 10, 1);
	function siteUserDecrement($data){
		if( isset($data['state']) ){
			if( $data['state'] == 0 )
				DB::update('site')->set('total_user = total_user-1')->send();
		}
	}
	event::add('userUpdated', 'siteUserDecrement', 10, 1);
