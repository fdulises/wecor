<?php

	namespace wecor;

	abstract class site{

		private static $meta = [];

		public static function getMeta( $key ){
			if( isset(self::$meta[$key]) ) return self::$meta[$key];
			return '';
		}

		public static function setMeta( $key, $value ){
			self::$meta[$key] = $value;
		}

		public static function deleteMeta( $key ){
			if( isset(self::$meta[$key]) ) unset(self::$meta[$key]);
		}

		public static function getLang(){
			if( isset($_COOKIE['sitelang']) ) return $_COOKIE['sitelang'];
			return 'es';
		}
	}
