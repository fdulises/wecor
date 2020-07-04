<?php
	/**
	*
	*/
	namespace wecor;
	class media{
		private static $basedir = '';
		public static function setBasedir($dir){
			self::$basedir = $dir;
		}
		public static function getBasedir($dir){
			return self::$basedir;
		}
		function __construct(){
			# code...
		}
		public static function listDir($uri){

			if( self::$basedir ) $uri = self::$basedir.'/'.$uri;
			$result = [];
			if( is_dir($uri) ){
				foreach (glob("{$uri}/*") as $k => $v) {
					$partes_ruta = pathinfo($v);
					$base = [];
					$base['title'] = $partes_ruta['filename'];
					$base['name'] = $partes_ruta['basename'];
					$base['url'] = $partes_ruta['basename'];
					if( is_file($v) ){
						$base['type'] = $partes_ruta['extension'];
						if( isset($GLOBALS['mediatypes'][$base['type']]) ) $base['icon'] = $GLOBALS['mediatypes'][$base['type']];
						else $base['icon'] = 'icon-file-o';
						$result[] = $base;
					}else if( is_dir($v) ){
						$base['type'] = 'dir';
						$base['icon'] = $GLOBALS['mediatypes'][$base['type']];
						$result[] = $base;
					}
				}
			}
			return $result;
		}

		public static function createDir($uri){
			if( self::$basedir ) $uri = self::$basedir.'/'.$uri;
			$info = [
				'state' => 0,
				'data' => [],
				'error' => [],
			];

			if( !is_dir($uri) ){
				if( mkdir($uri, 0777) ) $info['state'] = 1;
				else $info['error'][] = 'error_createdir';
			}else $info['error'][] = 'duplicated_dir';

			if( $info['state'] == 1 ){
				$basename = basename($uri);
				$info['data']['title'] = $basename;
				$info['data']['name'] = $basename;
				$info['data']['url'] = '';
				$info['data']['icon'] = 'icon-folder-open';
			}

			return $info;
		}

		public static function delete($ruta = ''){
			if( empty($ruta) ) die("Error Al intentar eliminar un archivo");
			$archivos = glob("{$ruta}/*");
			if( $archivos ) foreach($archivos as $v) unlink($v);
		}

		public static function upload($file, $dir = '', $rename = true){
			$info = [
				'state' => 0,
				'data' => [],
				'error' => [],
			];
			if( $file['error'] == 0 ){
				$file['name'] = strtolower(basename($file['name']));

				$fnam = pathinfo($file['name'], PATHINFO_FILENAME);
				$fext = pathinfo($file['name'], PATHINFO_EXTENSION);
				if( self::$basedir ) $adir[] = self::$basedir;
				if( $dir ) $adir[] = $dir;
				$adir = implode('/', $adir);
				$actualfile = $adir.'/'.$fnam.'.'.$fext;
				//Renombrar archivos duplicados
				if($rename){
					$increment = '';
					while(file_exists($adir.'/'.$fnam.$increment.'.'.$fext))
						$increment++;
					$actualfile = $adir.'/'.$fnam.$increment.'.'.$fext;
				}

				$movefile = move_uploaded_file($file['tmp_name'], $actualfile);
				if( $movefile ){
					$info['state'] = 1;

					$partes_ruta = pathinfo($actualfile);
					$base = [];
					$base['title'] = $partes_ruta['filename'];
					$base['name'] = $partes_ruta['basename'];
					$base['url'] = $partes_ruta['basename'];
					$base['type'] = $partes_ruta['extension'];
					if( isset($GLOBALS['mediatypes'][$base['type']]) ) $base['icon'] = $GLOBALS['mediatypes'][$base['type']];
					else $base['icon'] = 'icon-file-o';
					$info['data'] = $base;

				}else $info['error'][] = 'error_upload';
			}else{
				$info['error'][] = 'error_upload_'.$file['error'];
			}

			return $info;
		}
	}
