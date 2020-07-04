<?php

	namespace wecor;

	/**
	 *
	 */
	abstract class plugins{
		public static function getActiveList(){
			$plugins_active = config::get('site_plugins');
			$plugins_active = json_decode($plugins_active, true);
			if( $plugins_active ) return $plugins_active;
			return [];
		}
		public static function insert(){
			foreach (self::getActiveList() as $p_dir) {
				$p_route = PLUGINS_PATH."/{$p_dir}/frontoffice.php";
				if( file_exists($p_route) ) require $p_route;
			}
		}
	}
