<?php
	namespace wecor;

	site::setMeta( 'title', 'The leading spanish-bilingual newspaper' );
	site::setMeta( 'description', 'The leading spanish-bilingual newspaper' );
	site::setMeta( 'pagelink', config::get('site_url') );
	site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );

	require THEME_PATH.'/parts/header.php';
?>
        <!---contenedor principal del sitio.-->
        <div class="cont-main" id="contMain" data-state="hide">
            <!---Estructura inicial-->
            <main class="mg-sec container cards-raych-1">
                <div class="mg-sec pd-sec sombra">
                    <h3 class="tx-center rc-letterneon" id="shooter4"><?php echo $extras['about'] ?></h3>
                    <div class="cont-600 container">
					<p><img src="<?php echo THEME_URL ?>/img/Red-Latina-1.jpg"></p>
					<?php foreach ($about as $v): ?>
						<p><?php echo $v ?></p>
					<?php endforeach; ?>
					<p><img src="<?php echo THEME_URL ?>/img/Get-Noticed-1.jpg"></p>
                    </div>
                </div>
            </main>
        </div>

    </div>
<?php require THEME_PATH.'/parts/footer.php' ?>
