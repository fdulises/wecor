<?php

	namespace wecor;

	//Cargamos los plugins
	function pluginsLoad(){
		plugins::insert();
		themes::insert();
	}
	event::add('beforeLoadSec', 'pluginsLoad', 11);

	//Validamos que el usuario haya iniciado sesion
	function checkUserLogin(){
		if( !user::loginCheck() && routes::$controller != 'login' )
			header('location: '.APP_ROOT.'/login');
	}
	event::add('afterLoadSec', 'checkUserLogin');

	//Generamos menus dinamicos del dashboard
	function generateNavMenus(){
		require_once APP_ROOT_DIR.'/app/inc/navs.inc.php';
	}
	event::add('afterLoadSec', 'generateNavMenus');

	//Contadores de usuarios
	function siteUserIncrement($data){
		if( isset($data['state']) ){
			if( $data['state'] == 1 )
				config::set('count_users', config::get('count_users')+1);
		}
	}
	event::add('userCreated', 'siteUserIncrement', 10, 1);
	function siteUserDecrement($data){
		if( isset($data['state']) ){
			if( $data['state'] == 0 )
				config::set('count_users', config::get('count_users')-1);
		}
	}
	event::add('userUpdated', 'siteUserDecrement', 10, 1);
