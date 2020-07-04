<?php

	namespace wecor;

	/**
	 *
	 */
	abstract class themes{
		public static $themes_dir = APP_ROOT_DIR."/../themes";
		public static function getActive(){
			$themes_active = config::get( 'theme_dir' );
			if( $themes_active ) return $themes_active;
			return '';
		}
		public static function updateActive( $theme_dir ){
			config::set('theme_dir', $theme_dir);
		}
		public static function getlist(){
			$theme_active = self::getActive();
			$themes_list = [];
			$themes_url = config::get('site_url').'/'.THEMES_DIR;
			foreach (glob(self::$themes_dir."/*") as $file) {
				if( is_dir($file) ){
					$file_route = "{$file}/info.json";
					if( file_exists($file_route) ){
						$pcont = file_get_contents($file_route);
						$data = json_decode($pcont, true);
						$data['url'] = "{$themes_url}/{$data['dir']}";
						$data['dir'] = THEMES_DIR.'/'.$data['dir'];
						$data['state'] = 0;
						if( $data['dir'] == $theme_active ) $data['state'] = 1;
						$themes_list[] = $data;
					}
				}
			}
			return $themes_list;
		}
		public static function insert(){
			$theme_active = self::getActive();
			$p_route = self::$themes_dir."/{$theme_active}/php/backoffice.php";
			if( file_exists($p_route) ) require $p_route;
		}
		public static function set( $dir, $name ){
			config::set('theme_dir', $dir);
			config::set('theme_name', $name);
		}
	}
