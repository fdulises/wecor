<?php

	namespace wecor;

	class stcache{
		private $cachedir = APP_ROOT_DIR.'/cache/';
		private $cacheext = '.cache';
		private $cachename = '';
		public $contbufer = '';

		public function __construct($name = ''){
			$this->cachename = $name;
		}
		public function start(){
			ob_start();
		}
		public function setCacheDir($dir){
			$this->cachedir = $dir;
		}
		public function setCacheExt($ext){
			$this->cacheext = $ext;
		}
		public function end(){
			$this->contbufer = ob_get_contents();
			ob_end_clean();

			echo $this->contbufer;

			$this->save();
		}
		public function save(){
			if( !empty($this->cachename) )
				file_put_contents($this->cachedir.$this->cachename.$this->cacheext, $this->contbufer);
		}
		public static delete($name){
			unlink($this->cachedir.$name.$this->cacheext);
		}
	}
