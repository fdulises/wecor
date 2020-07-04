<?php
	namespace wecor;

	site::setMeta( 'pagetitle', config::get('site_title').' - '.site::getMeta('title') );

?>
<!DOCTYPE html>
<html lang="<?php echo site::getMeta('lang') ?>">
<head>
	<meta charset="<?php echo site::getMeta('charset') ?>">
	<meta name="viewport" content="<?php echo site::getMeta('viewport') ?>" />
	<title><?php echo site::getMeta('pagetitle'); ?></title>

	<meta name="description" content="<?php echo site::getMeta('description'); ?>"/>

	<link rel="icon" href="<?php echo site::getMeta('icon') ?>" />
	<link rel="canonical" href="<?php echo site::getMeta('pagelink') ?>" />

	<meta name='og:type' content='article' >
	<meta name='og:title' content='<?php echo site::getMeta('pagetitle') ?>' >
	<meta name='og:description' content='<?php echo site::getMeta('description') ?>'>
	<meta name='og:url' content='<?php echo site::getMeta('pagelink') ?>' >
	<meta name='og:image' content='<?php echo site::getMeta('cover') ?>' >

	<link rel="stylesheet" href="<?php echo THEME_URL ?>/css/fonts.css">
	<link rel="stylesheet" href="<?php echo THEME_URL ?>/css/listefi.css">
	<link rel="stylesheet" href="<?php echo THEME_URL ?>/css/style.css">

	<script>
	var SITIO_SEC = "<?php echo basename($controller, ".php") ?>";
	var APP_ROOT = "<?php echo APP_ROOT ?>";
	</script>
</head>
<body>
	<header id="header">
		<nav class="nav-bar">
			<div class="container">
				<div class="nav-brand">
					<a href="<?php echo config::get('site_url') ?>"><img src="<?php echo THEME_URL ?>/img/logo-debred.png" alt="" title="Debred"/></a>
				</div>
				<button id="btnshownav" class="btn-sadw hide-min-b bx-right">
					<span class="line"></span>
					<span class="line"></span>
					<span class="line"></span>
				</button>
				<ul class="bx-right">
					<li><a href="<?php echo config::get('site_url') ?>/">Inicio</a><span class="border-b"></span></li>
					<li><a href="<?php echo config::get('site_url') ?>/nosotros">Acerca de</a><span class="border-b"></span></li>
					<li><a href="<?php echo config::get('site_url') ?>/contacto">Contacto</a><span class="border-b"></span></li>
				</ul>
			</div>
		</nav>
	</header>
