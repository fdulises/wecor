<?php
	namespace wecor;

	$catlist = extras::htmlentities(cat::getList([
		'columns' => ['id', 'title', 'slug'],
		'order' => 'title ASC',
		'lang' => $sitelang,
	]));
?>
</div>
<!--Pie de Pagina-->
<footer class="clearfix flx-cent" id="foo-blur">
    <div class="gd-33 gd-m-100">
        <p class="tx-center fnt-white">
            <?php echo $extras['copy'] ?>
        </p>
        <div class="mg-sec">
            <div class="gd-33 gd-s-100 tx-center">
                <div class="cont-tooltip-down">
                    <a href="https://twitter.com/redlatinastl/"><span class="icon-twitter material-icons"></span></a>
                    <span class="tooltip-text"><?php echo $extras['visit1'] ?></span>
                </div>
            </div>
            <div class="gd-33 gd-s-100 tx-center">
                <div class="cont-tooltip-down">
                    <a href="https://www.instagram.com/redlatinastl/"><span class="icon-instagram material-icons"></span></a>
                    <span class="tooltip-text"><?php echo $extras['visit2'] ?></span>
                </div>
            </div>
            <div class="gd-33 gd-s-100 tx-center">
                <div class="cont-tooltip-down">
                    <a href="https://www.facebook.com/redlatina/"><span class="icon-facebook material-icons"></span></a>
                    <span class="tooltip-text"><?php echo $extras['visit3'] ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="gd-33 gd-m-100">
        <a href="<?php echo config::get('site_url') ?>/index">
            <h4 class="fnt-white tx-center"><img class="logored" src="<?php echo THEME_URL ?>/ftr-logo.png" alt="ftr-logo.png"></h4>
        </a>
    </div>
    <div class="gd-33 gd-m-100">
        <ul class="bx-center">
            <li class="">
                <a href="<?php echo config::get('site_url') ?>/index"><span class="icon-home fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_home'] ?></span></span></a>
            </li>
            <li class="">
                <a href="<?php echo config::get('site_url') ?>/contact"><span class="icon-gears fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_services'] ?></span></span></a>
            </li>
            <li class="">
                <a href="<?php echo config::get('site_url') ?>/about"><span class="icon-info fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_about'] ?></span></span></a>
            </li>
            <li class="">
                <a href="<?php echo config::get('site_url') ?>/chanel"><span class="icon-youtube fnt-white pd-few"> <span class="roboto"><?php echo $language_menu['link_chanel'] ?></span></span></a>
            </li>
        </ul>
    </div>
</footer>
<!--Formulario de busqueda-->
<div id="BoxSearch">
    <div class="gd-100 tx-center">
        <h3 class="tx-Center mg-sec fnt-white"><?php echo $extras['search'] ?></h3>
        <form class="cont-600 container tx-center" method="get" action="<?php echo config::get('site_url') ?>/search" id="cont-form">
            <div class="cont-input">
                <input type="text" name="s" class="input-material" required />
                <span class="highlight highlight-indigo"></span>
                <span class="bar bar-indigo"></span>
                <label class="blue icon-search label-material"> <?php echo $extras['searchAction'] ?></label>
            </div>
            <button class="btn-material blue-material" type="submit" id="form1"><span><?php echo $extras['searchButton'] ?></span></button>
        </form>
        <!--Categorias-->
        <div class="cont-1000 bx-center" id="cont-categories">
            <h3 class="tx-center fnt-white"><?php echo $extras['cats'] ?></h3>
            <div class="order-grids">
                <?php foreach ($catlist as $c): ?>
                <div class="gd-16 gd-b-100 mg-sec">
                    <a href="<?php echo config::get('site_url') ?>/cat/<?php echo urlencode($c['slug']) ?>"><button class="btn-material indigo-material"><span class=""> <?php echo $c['title'] ?></span></button></a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
    <!--Enlaces de JavaScrpt-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-146527082-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-146527082-1');
	</script>
    <script src="<?php echo THEME_URL ?>/js/listefi.js"></script>
    <script src="<?php echo THEME_URL ?>/js/raychel.js"></script>
    <script src="<?php echo THEME_URL ?>/js/main.js"></script>
</body>
</html>
