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

	$lagslist = array(
		'es' => 'Español',
		'en' => 'English',
	);
