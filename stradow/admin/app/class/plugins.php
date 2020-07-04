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
		public static function toogle( $id ){
			$plugins_active = self::getActiveList();
			$inarray = array_search( $id, $plugins_active );
			if( is_int( $inarray ) ) unset( $plugins_active[$inarray] );
			else $plugins_active[] = $id;
			return config::set('site_plugins', json_encode($plugins_active));
		}
		public static function getlist(){
			$plugins_active = self::getActiveList();
			$plugins_list = [];
			foreach (glob(PLUGINS_DIR."/*") as $file) {
				if( is_dir($file) ){
					$file_route = "{$file}/info.json";
					if( file_exists($file_route) ){
						$pcont = file_get_contents($file_route);
						$data = json_decode($pcont, true);
						$data['dir'] = basename($file);
						$data['state'] = 0;
						if( in_array($data['dir'], $plugins_active) ) $data['state'] = 1;
						$plugins_list[] = $data;
					}
				}
			}
			return $plugins_list;
		}
		public static function insert(){
			foreach (self::getActiveList() as $p_dir) {
				$p_route = PLUGINS_DIR."/{$p_dir}/backoffice.php";
				if( file_exists($p_route) ) require $p_route;
			}
		}
	}
