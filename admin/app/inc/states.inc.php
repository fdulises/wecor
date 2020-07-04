<?php

	namespace wecor;

	$userstate = array(
		0 => 'Eliminado',
		1 => 'Activo',
		2 => 'Inactivo',
		3 => 'Suspendido',
	);

	$groups = array(
		1 => array('id' => 1, 'name' => 'Super Administrador'),
		2 => array('id' => 2, 'name' => 'Administrador'),
		3 => array('id' => 3, 'name' => 'Editor'),
		4 => array('id' => 4, 'name' => 'Autor'),
		5 => array('id' => 5, 'name' => 'Colaborador'),
		6 => array('id' => 6, 'name' => 'Miembro'),
	);

	$mediatypes = [
		'jpg' => 'icon-file-image-o',
		'png' => 'icon-file-image-o',
		'bmp' => 'icon-file-image-o',
		'gif' => 'icon-file-image-o',
		'jpeg' => 'icon-file-image-o',
		'pdf' => 'icon-file-pdf-o',
		'mp3' => 'icon-file-audio-o',
		'wav' => 'icon-file-audio-o',
		'mp4' => 'icon-file-movie-o',
		'webm' => 'icon-file-movie-o',
		'ogg' => 'icon-file-movie-o',
		'txt' => 'icon-i-cursor',
		'html' => 'icon-file-code-o',
		'js' => 'icon-file-code-o',
		'css' => 'icon-file-code-o',
		'php' => 'icon-file-code-o',
		'zip' => 'icon-file-archive-o',
		'rar' => 'icon-file-archive-o',
		'xlsx' => 'icon-file-excel-o',
		'csv' => 'icon-file-excel-o',
		'default' => 'icon-file-o',
		'dir' => 'icon-folder-open',
	];

	$imgtype = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];

	$lagslist = array(
		'es' => 'Español',
		'en' => 'English',
	);
