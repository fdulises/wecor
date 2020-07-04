<?php

	namespace wecor;

	/**
	 *
	 */
	abstract class themes{
		public static function insert(){
			$main = realpath(THEME_PATH."/php/frontoffice.php");
			if( file_exists($main) ) require $main;
		}
	}
