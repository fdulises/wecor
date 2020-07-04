<?php

	namespace wecor;

	$GLOBALS['usermenu'] = new navMenu;
	$GLOBALS['usermenu']->addLink([
		'id' => 'logout',
		'title' => 'Cerrar Sesión',
		'url' => APP_ROOT.'/logout',
		'icon' => '<span class="icon-power-off"></span>',
	]);
	if(isset($_SESSION[S_USERID])){
	$GLOBALS['usermenu']->addLink([
		'id' => 'prifile',
		'title' => 'Editar perfil',
		'url' => APP_ROOT.'/users/update/'.$_SESSION[S_USERID],
		'icon' => '<span class="icon-user"></span>',
	]);
	}
	$GLOBALS['usermenu']->addLink([
		'id' => 'linksite',
		'title' => 'Ver sitio',
		'url' => config::get('site_url'),
		'icon' => '<span class="icon-link"></span>',
	]);
	/*$GLOBALS['usermenu']->addLink([
		'id' => 'notifications',
		'title' => 'Notificaciones',
		'url' => '#',
		'icon' => '<span class="icon-bell-o"></span>',
	]);*/

	$GLOBALS['mainmenu'] = new navMenu;
	$GLOBALS['mainmenu']->addLink([
		'id' => 'logout',
		'title' => 'Cerrar Sesión',
		'url' => APP_ROOT.'/logout',
		'icon' => '<span class="icon-power-off"></span>',
		'meta' => ['class'=>'hide-min-m']
	]);
	if(isset($_SESSION[S_USERID])){
	$GLOBALS['mainmenu']->addLink([
		'id' => 'profile',
		'title' => 'Editar perfil',
		'url' => APP_ROOT.'/users/update/'.$_SESSION[S_USERID],
		'icon' => '<span class="icon-user"></span>',
		'meta' => ['class'=>'hide-min-m']
	]);
	}
	$GLOBALS['mainmenu']->addLink([
		'id' => 'linksite',
		'title' => 'Ver sitio',
		'url' => config::get('site_url'),
		'icon' => '<span class="icon-link"></span>',
		'meta' => ['class'=>'hide-min-m']
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'config',
		'title' => 'Configuración',
		'url' => APP_ROOT.'/config',
		'icon' => '<span class="icon-cog"></span>',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'cms',
		'title' => 'Información',
		'url' => APP_ROOT.'/cms',
		'parent' => 'config',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'users',
		'title' => 'Usuarios',
		'url' => APP_ROOT.'/users',
		'icon' => '<span class="icon-users"></span>',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'users_create',
		'title' => 'Agregar Usuario',
		'url' => APP_ROOT.'/users/create',
		'parent' => 'users',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'pages',
		'title' => 'Páginas',
		'url' => APP_ROOT.'/pages',
		'icon' => '<span class="icon-file-text"></span>',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'pages_create',
		'title' => 'Agregar página',
		'url' => APP_ROOT.'/pages/create',
		'parent' => 'pages',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'pages_bin',
		'title' => 'Páginas eliminadas',
		'url' => APP_ROOT.'/pages/bin',
		'parent' => 'pages',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'post',
		'title' => 'Entradas',
		'url' => APP_ROOT.'/post',
		'icon' => '<span class="icon-calendar"></span>',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'post_create',
		'title' => 'Agregar Entrada',
		'url' => APP_ROOT.'/post/create',
		'parent' => 'post',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'post_bin',
		'title' => 'Entradas eliminadas',
		'url' => APP_ROOT.'/post/bin',
		'parent' => 'post',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'post_tags',
		'title' => 'Etiquetas',
		'url' => APP_ROOT.'/tags',
		'parent' => 'post',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'post_tags_create',
		'title' => 'Agregar etiqueta',
		'url' => APP_ROOT.'/tags/create',
		'parent' => 'post',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'cats',
		'title' => 'Categorías',
		'url' => APP_ROOT.'/cats',
		'icon' => '<span class="icon-bookmark"></span>',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'cats_create',
		'title' => 'Agregar categoría',
		'url' => APP_ROOT.'/cats/create',
		'parent' => 'cats',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'plugins',
		'title' => 'Complementos',
		'url' => APP_ROOT.'/plugins',
		'icon' => '<span class="icon-puzzle-piece"></span>',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'themes',
		'title' => 'Temas',
		'url' => APP_ROOT.'/themes',
		'icon' => '<span class="icon-paint-brush"></span>',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'adsgroups',
		'title' => 'Banners Publicitarios',
		'url' => APP_ROOT.'/adsgroups',
		'icon' => '<span class="icon-certificate"></span>',
	]);
	$GLOBALS['mainmenu']->addLink([
		'id' => 'adsgroups_create',
		'title' => 'Agregar Grupo',
		'url' => APP_ROOT.'/adsgroups/create',
		'parent' => 'adsgroups',
	]);
	/*$GLOBALS['mainmenu']->addLink([
		'id' => 'media',
		'title' => 'Gestor de medios',
		'url' =>  APP_ROOT.'/media',
		'icon' => '<span class="icon-folder-open"></span>',
	]);*/
