<?php
	namespace wecor;
	/**
	*
	*/
	class backOffice{
		/*
			backOffice::addSection([
				'id' => 'posts',
				'title' => 'Entradas',
				'route' => 'posts',
				'controller' => 'posts',
				'mainmenu' => true,
				'url' => APP_ROOT.'/posts',
				'icon' => '<span class="icon-home"></span>',
			]);
			backOffice::addSection([
				'id' => 'postsCrate',
				'title' => 'Agregar entrada',
				'route' => 'post\/create',
				'controller' => 'posts.create',
				'mainmenu' => true,
				'url' => APP_ROOT.'/posts/create',
				'parent' => 'posts',
			]);
			backOffice::addSection([
				'id' => 'postsUpdate',
				'title' => 'Editar entrada',
				'route' => 'post\/update\/(\d+)',
				'controller' => 'posts.update',
			]);
		*/
		public static function addSection( $data ){
			//if( isset($data['title']) ) $GLOBALS['page_title'] = $data['title'];
			if( isset($data['route'], $data['controller']) ){
				routes::add( $data['route'], $data['controller']);
			}
			if( isset($data['mainmenu']) ){
				$datamenu = [];
				if( isset( $data['id'] ) ) $datamenu['id'] = $data['id'];
				if( isset( $data['parent'] ) ) $datamenu['parent'] = $data['parent'];
				if( isset( $data['title'] ) ) $datamenu['title'] = $data['title'];
				if( isset( $data['icon'] ) ) $datamenu['icon'] = $data['icon'];
				if( isset( $data['meta'] ) ) $datamenu['meta'] = $data['meta'];
				if( isset( $data['url'] ) ) $datamenu['url'] = $data['url'];
				$GLOBALS['mainmenu']->addLink($datamenu);
			}
		}
	}
