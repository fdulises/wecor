<?php
	namespace wecor;


	backOffice::addSection([
		'id' => 'wpimport',
		'title' => 'Wp Import',
		'route' => 'wpimport',
		'controller' => dirname(__FILE__).'/sec/wpimport.sec.php',
		'url' => APP_ROOT.'/wpimport',
		'icon' => '<span class="icon-cog"></span>',
	]);
