<?php

	/*
	* Algoritmo para importación de contenido desde wordpress creado para el sitio redlatina
	*/
	
	namespace wecor;

	$wp = isset($_GET['wp']) ? (INT) $_GET['wp'] : 0;
	if( !$wp ) exit('Sin datos. Proceso terminado');

	//Hace peticion http y retorna headers y array de post wordpress
	function getwpdata($url){
		$httpreq = new HttpConnection;
		$result = $httpreq->get($url);
		$result = json_decode($result, true);
		return [
			'html' => $result,
			'headers' => $httpreq::$hdrs,
		];
	}
	//Elimina etiquetas de shortcodes perdidos
	function removeShortcodes($content){
		$shortlist = [
			'/\[vc_row\]/i' => "",
			'/\[vc_column\]/i' => "",
			'/\[vc_column_text\]/i' => "",
			'/\[vc_tabs\]/i' => "",
			'/\[vc_tab(.*)\]/i' => "",
			'/\[\/vc_row\]/i' => "",
			'/\[\/vc_column\]/i' => "",
			'/\[\/vc_column_text\]/i' => "",
			'/\[\/vc_tabs\]/i' => "",
			'/\[\/vc_tab(.*)\]/i' => "",
		];
		$content = preg_replace(array_keys($shortlist), array_values($shortlist), $content);
		return $content;
	}
	//Prepara la entrada para guardarla
	function formatPost($p){
		$return = [];
		//Preparamos datos de la entrada por defecto
		$data = [];
		$data['type'] = 'post';
		$data['lang'] = 'en';
		$data['wpid'] = $p['id'];
		$data['created'] = $p['date'];
		$data['updated'] = $p['modified'];
		$data['slug'] = $p['slug'];
		$data['title'] = $p['title']['rendered'];
		$data['content'] = $p['content']['rendered'];
		$data['descrip'] = removeShortcodes($p['excerpt']['rendered']);
		$data['cover'] = $p['_links']['wp:featuredmedia'][0]['href'];

		//Hacemos otra peticion para obtener url de la imagen principal
		$data['cover'] = getwpdata($data['cover'])['html']['guid']['rendered'];

		//Recuperamos titulo en español desde la etiqueta h1
		$estitle = '';
		preg_match_all('/<h1[^>]*>(.*?)<\/h1>/i', $data['content'], $festitle);
		if( isset($festitle[1][0]) ){
			if( !empty($festitle[1][0]) ) $estitle = $festitle[1][0];
		}
		//Eliminamos el h1
		$data['content'] = preg_replace('/<h1[^>]*>(.*?)<\/h1>/is', "", $data['content']);

		//recuperamos contenido en español
		preg_match_all('/\[vc_tab [^\]]*(?:Spanish Version)+[^\]]*\](.*?)\[\/vc_tab\]/is', $data['content'], $escont);
		if( isset($escont[1][0]) ) $escont = $escont[1][0];
		else $escont = '';

		//recuperamos contenido en ingles
		preg_match_all('/\[vc_tab [^\]]*(?:English Version)+[^\]]*\](.*?)\[\/vc_tab\]/is', $data['content'], $encont);
		if( isset($encont[1][0]) ){
			$encont = $encont[1][0];
			$data['content'] = $encont;
		}else $encont = '';

		$return['en'] = $data;

		//Preparamos entrada version en español
		if( $escont ){
			$esdata = $data;
			$esdata['lang'] = 'es';
			$esdata['content'] = $escont;
			if( $estitle ) $esdata['title'] = $estitle;

			$return['es'] = $esdata;
		}

		return $return;
	}

	//Total de paginas 2019-08-23 = 537

	//Url de la api wordpress
	$urltog = 'https://www.redlatinastl.com/wp-json/wp/v2/posts?page='.$wp;

	//Array informativo
	$state = [
		'processed' => 0,
		'error' => 0,
		'page' => $wp,
	];

	//Obtenemos el contenido via http
	$reqcont = getwpdata($urltog);
	$listapost = $reqcont['html'];

	//Información necesaria para paginacion
	/*$rheaders = $reqcont['headers'];
	$totalpost = $rheaders['x-wp-total'][0];
	$totalp = $rheaders['x-wp-totalpages'][0];*/

	for($i=0;$i<count($listapost); $i++){
		//Preparamos e insertamos el post en ingles
		$data = formatPost($listapost[$i]);
		$result = post::create($data['en']);
		if( $result ){
			$state['processed']++;
			//Si existe la version en ingles la publicamos
			if( isset($data['es']) ){
				$data['es']['verof'] = $result;
				post::create($data['es']);
			}
		}else $state['error']++;
	}

	extras::print_r($state);
	$awp = $wp-1;
	echo "<a href='wpimport?wp=$awp'>Página siguiente $awp</a>";
