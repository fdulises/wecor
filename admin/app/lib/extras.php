<?php
	namespace wecor;
	abstract class extras{

		public static function print_r($datos){
			print "<pre>";
			print_r($datos);
			print "</pre>";
		}

		/*
		* Metodo para dar el formato deseado a la fecha y el tiempo
		*/
		public static function formatoDate($cadena, $formato){
			return date( $formato, strtotime($cadena) );
		}

		/*
		* Metodos para escapar codigo html
		*
		*/
		public static function htmlentities($datos){
			if( is_array($datos) ){
				foreach ($datos as $k => $v) $datos[$k] = self::htmlentities($v);
				return $datos;
			}
			return htmlentities($datos, ENT_COMPAT, 'UTF-8');
		}

		/*
		* Metodos para eliminar codigo html
		*
		*/
		public static function striptags($datos){
			if( is_array($datos) ){
				foreach ($datos as $k => $v) $datos[$k] = self::striptags($v);
				return $datos;
			}
			return strip_tags($datos);
		}

		/*
		* Metodo para generar gravarar
		*/
		public static function urlGravatar($email, $size, $d = 'mm'){
			$hash = md5( strtolower( trim( $email ) ) );
			return "http://www.gravatar.com/avatar/{$hash}.jpg?s={$size}&d={$d}";
		}

		/*
		* Metodo para registrar error en el archivo de errores
		*/
		public static function log($msg){
			error_log($msg, 3, "errors.log");
		}

		/*
		* Metodo para verificar campos vacios
		*/
		public static function emptyCheck($data){
			$error = array();
			if( !is_array($data) ) $data = array($data);
			foreach ($data as $k => $v) {
				if( $v === "" ) $error[$k] = $k.'_empty';
			}
			return $error;
		}

		/*
		* Metodos para sanitizar campos
		*/
		public static function fieldSanitize($datos){
			if( is_array($datos) ) $datos = array_map(
				function($n){return filter_var($n, FILTER_SANITIZE_STRING);},
				$datos
			);
			else $datos = filter_var($datos, FILTER_SANITIZE_STRING);
			return $datos;
		}

		/*
		* Metodos para obtener slug valido
		*/
		public static function getSlug($string){
			$slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
			return $slug;
		}

		/*
		* Metodos para para forzar error 404
		*/
		public static function e404(){
			header('HTTP/1.0 404 Not Found');
			@header("Status: 404 Not Found");
			if( file_exists(APP_SEC_DIR.'/error404.sec.php') )
				require_once realpath( APP_SEC_DIR.'/error404.sec.php' );
			exit();
		}
	}
