<?php

	/*
	* Archivo de configuracion de rutas
	* Lista con las rutas y sus controladores
	*/

	namespace wecor;

	routes::add( '/', 							'index');
	routes::add( 'index', 						'index');
	routes::add( 'config', 						'config');
	routes::add( 'cms', 						'cms');
	routes::add( 'login',						'login');
	routes::add( 'logout',						'logout');
	routes::add( 'users',						'users');
	routes::add( 'users\/create',				'users.create');
	routes::add( 'users\/update\/(\d+)',		'users.update');
	routes::add( 'plugins',						'plugins');
	routes::add( 'themes',						'themes');
	routes::add( 'media',						'media');
	routes::add( 'media\/upload',				'media.upload');
	routes::add( 'pages',						'pages');
	routes::add( 'pages\/bin',					'pages.bin');
	routes::add( 'pages\/create',				'pages.create');
	routes::add( 'pages\/create\/(\d+)',		'pages.create');
	routes::add( 'pages\/update\/(\d+)',		'pages.update');
	routes::add( 'cats',						'cats');
	routes::add( 'cats\/create',				'cats.create');
	routes::add( 'cats\/create\/(\d+)',			'cats.create');
	routes::add( 'cats\/update\/(\d+)',			'cats.update');
	routes::add( 'post',						'post');
	routes::add( 'post\/bin',					'post.bin');
	routes::add( 'post\/create',				'post.create');
	routes::add( 'post\/create\/(\d+)',			'post.create');
	routes::add( 'post\/update\/(\d+)',			'post.update');
	routes::add( 'tags',						'tags');
	routes::add( 'tags\/create',				'tags.create');
	routes::add( 'tags\/update\/(\d+)',			'tags.update');
	routes::add( 'adsgroups',					'adsgroups');
	routes::add( 'adsgroups\/create',			'adsgroups.create');
	routes::add( 'adsgroups\/update\/(\d+)',	'adsgroups.update');
	routes::add( 'ads\/(\d+)',					'ads');
	routes::add( 'ads\/create\/(\d+)',			'ads.create');
	routes::add( 'ads\/update\/(\d+)',			'ads.update');
