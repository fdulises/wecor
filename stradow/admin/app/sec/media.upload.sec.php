<?php
	namespace wecor;

	$result = [
		'state' => 0,
		'error' => [],
		'data' => [],
	];

	$basedir = MEDIA_DIR;
	if( isset($_POST['subdir']) ) $basedir .= "/{$_POST['subdir']}";

	media::setBasedir($basedir);

	if( isset($_POST['createdir']) ){
		$result = media::createDir($_POST['createdir']);
	}else if( isset($_FILES['newup']) ){
		$result = media::upload($_FILES['newup']);

		if( $result['state'] == 1 ){
			
			$murl = config::get('site_url')."/media/";
			if( isset($_POST['subdir']) ) $murl .= $_POST['subdir'].'/';
			$murl .= $result['data']['url'];
			$result['data']['url'] = $murl;
		}


	}


	echo json_encode($result);
