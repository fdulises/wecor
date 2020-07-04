<?php
	namespace wecor;

	$GLOBALS['editorsections'] = [
		'post.create',
		'post.update',
		'pages.create',
		'pages.update',
		'post.mlcreate',
		'post.mlupdate',
		'ads.create',
		'ads.update',
	];

	function listefieditor(){

		if( in_array(routes::$controller, $GLOBALS['editorsections']) ){
			//Cargamos archivo javascript
			event::add('footer_loaded', function(){
				$jsurl = config::get('site_url')."/plugins/listefi_editor/js/liweditor.js";
				$jsurlmain = config::get('site_url')."/plugins/listefi_editor/js/main.js";
				echo '<script src="'.$jsurl.'"></script><script src="'.$jsurlmain.'"></script>';
			});
			//Cargamos hoja de estilos
			event::add('header_loaded', function(){
				echo '<link rel="stylesheet" href="'.config::get('site_url')."/plugins/listefi_editor/css/liweditor.css".'">';
				echo '<link rel="stylesheet" href="'.config::get('site_url')."/plugins/listefi_editor/css/main.css".'">';
			});
			//Agregamos la funcion update
			event::add('postSubmit', function(){
				echo "myeditor.update();\n";
			});
		}
	}

	event::add('afterLoadSec', 'listefieditor');
