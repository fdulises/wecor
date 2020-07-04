<?php
	namespace wecor;

	site::setMeta( 'pagetitle', config::get('site_title').' - '.site::getMeta('title') );
?>
<!DOCTYPE html>
<html lang="<?php echo site::getMeta('lang') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo THEME_URL ?>/css/listefi.css">
    <link rel="stylesheet" href="<?php echo THEME_URL ?>/css/raychel.css">
    <link rel="stylesheet" href="<?php echo THEME_URL ?>/css/fonts.css">
    <link rel="stylesheet" href="<?php echo THEME_URL ?>/css/styles.css">
    <title><?php echo site::getMeta('pagetitle'); ?></title>
	<meta name="description" content="<?php echo site::getMeta('description'); ?>"/>
	<link rel="canonical" href="<?php echo site::getMeta('pagelink') ?>" />
	<meta name='og:type' content='article' >
	<meta name='og:title' content='<?php echo site::getMeta('pagetitle') ?>' >
	<meta name='og:description' content='<?php echo site::getMeta('description') ?>'>
	<meta name='og:url' content='<?php echo site::getMeta('pagelink') ?>' >
	<meta name='og:image' content='<?php echo site::getMeta('cover') ?>' >
	<link rel="icon" href="<?php echo THEME_URL ?>/favicon.ico" />
    <link rel="stylesheet" href="<?php echo THEME_URL ?>/css/notifications.css">
</head>
<body class="body-mgtop">
     <!---Encabezado del sitio.-->
    <header class="gd-100 header-board">
        <div class="btn-menu gd-10 gd-m-10 fr">
            <button class="btn phantom-white" id="btnMenu">
                <span class="icon-bars"></span>
            </button>
        </div>
        <div class="logo-cont gd-60 gd-m-40 tx-left fr">
            <a href="<?php echo config::get('site_url') ?>/index">
                <h4 class="fnt-white tx-left"><img class="logored" src="<?php echo THEME_URL ?>/ftr-logo.png" alt="ftr-logo.png"></h4>
            </a>
        </div>
        <div class="btn-menu gd-20 gd-m-40">
            <a href="#">
                <button id="btnlang" class="btn phantom-white fr">
                    <span class="icon-globe fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_changelang'] ?></span></span>
                </button>
            </a>
        </div>

        <div class=" gd-10 gd-m-10 fr">
            <button class="btn phantom-white" id="searchButton">
                <span class="icon-search"></span>
            </button>
        </div>
    </header>
    <!---contenedor principal del menu y del sitio.-->
    <div class="container cont-1400">
      <!---contenedor principal del menu.-->
      <nav class="navigation" id="contMenu" data-state="hide">
            <ul class="bx-center">
                <li class="btn-material">
                    <a href="<?php echo config::get('site_url') ?>/index"><span class="icon-home fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_home'] ?></span></span></a>
                </li>
                <li class="btn-material">
                    <a href="<?php echo config::get('site_url') ?>/about"><span class="icon-info fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_about'] ?></span></span></a>
                </li>
                <li class="btn-material">
                    <a href="<?php echo config::get('site_url') ?>/contact"><span class="icon-gears fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_services'] ?></span></span></a>
                </li>
                <li class="btn-material">
                    <a href="<?php echo config::get('site_url') ?>/chanel"><span class="icon-youtube fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_chanel'] ?></span></span></a>
                </li>
            </ul>
        </nav>
		<div id="radiostream">
			<audio controls><source src="http://72.29.70.22:9310/stream" type="audio/mpeg"></audio>
		</div>
