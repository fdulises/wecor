<?php

	namespace wecor;

	/*
	* Routes - Sistema de manejo de rutas
	* V 17.05.10
	*/

	abstract class routes{

		private static $controllers = [];
		private static $actions = [];

		public static $controller = '';
		public static $params = [];

		public static function add( $controller, $action = null){
			if( is_string($controller) ){
				if( $controller !== '/' ) $controller = trim($controller, '/');
				else $controller = '\/';

				self::$controllers["/^{$controller}$/i"] = "/^{$controller}$/i";
				self::$actions["/^{$controller}$/i"] = $action;
			}else if ( is_callable($controller) ){
				self::$controllers[] = $controller;
				self::$actions[] = '';
			}
		}

		/*
		* Metodo para determinar el controlador de la ruta
		*/
		public static function get( ){
			$url = isset( $_GET['url'] ) ? $_GET['url'] : '';
			$url = trim($url, '/');
			if( $url == '' ) $url = '/';

			$result = [];
			foreach( self::$controllers as $route => $controller ){
				if( is_callable($controller) ){
					//Determinamos manualmente el controllador usando metodo del usuario
					if( $userResult = call_user_func( $controller, $url ) ){
						$result = $userResult;
						break;
					}
				}else{
					//Determinamos automaticamente el controllador
					if( preg_match( $route, $url, $resultpreg ) ){
						$result['controller'] = self::$actions[$route];
						$result['params'] = $resultpreg;
						break;
					}
				}
			}
			//extras::print_r($result);
			if( $result ){
				self::$controller = isset( $result['controller'] ) ? $result['controller'] : '';
				self::$params = isset( $result['params'] ) ? $result['params'] : '';
			}else self::$controller = 'error404';
		}

	}
