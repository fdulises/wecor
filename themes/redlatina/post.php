<?php
	namespace wecor;

	//Obtenemos entrada si existe en el idioma solicitado
	$entrada = post::get([
		'columns' => [
			'p.id', 'p.title', 'p.slug', 'p.descrip', 'p.updated', 'p.cover', 'p.coverlocal', 'p.content'
		],
		'type' => 'post',
		'slug' => routes::$params[1],
		'lang' => $sitelang,
	]);

	if( !$entrada ) extras::e404();

	$entrada['link'] = config::get('site_url').'/'.$entrada['slug'];
	$entrada['cover'] = post::getPostCover($entrada);
	
	site::setMeta( 'title', $entrada['title'] );
	site::setMeta( 'description', $entrada['descrip'] );
	site::setMeta( 'pagelink', $entrada['link'] );
	site::setMeta( 'cover', $entrada['cover'] );

	//Obtenemos grupo publicitario
	$adspost = ad::getList([
		'groupid' => 1,
		'columns' => [
			'a.id', 'a.title', 'a.link', 'a.state', 'a.content'
		],
		'order' => 'id ASC',
	]);


	require THEME_PATH.'/parts/header.php';
?>
        <!---contenedor principal del sitio.-->
        <div class="cont-main" id="contMain" data-state="hide">
            <!---Estructura inicial-->
            <div class="mg-sec container">
                <main class="gd-70 gd-b-100">
                    <!---Card Principal-->
                        <div class="cards-raych-1 gd-100 gd-b-100 gd-s-100 mg-sec" id="smoove-up" data-state="show">
                            <div class="sombra">
                                <!--<img src="<?//php echo $entrada['cover'] ?>" alt="" class="imagenes" />-->
                                <h3 class="tx-center fnt-black"><?php echo $entrada['title'] ?></h3>
                                <p><?php echo $entrada['content']; ?><p>
                            </div>
                        </div>
                    <!---Card De Comentarios Hechos Por Usuarios-->
					<div class="mg-sec">
						<div id="disqus_thread"></div>
						<script>
							(function() { // DON'T EDIT BELOW THIS LINE
							var d = document, s = d.createElement('script');
							s.src = 'https://red-latina.disqus.com/embed.js';
							s.setAttribute('data-timestamp', +new Date());
							(d.head || d.body).appendChild(s);
							})();
						</script>
						<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
					</div>
                </main>
                <aside class="gd-30 hide-b">
                    <!---Cards De Seccion Secundaria-->
                    <div class="mg-sec" id="smoove-up" data-state="show" style="position:fixed; width: 30vw;">
						<div class="card-aside">
							<script type="text/javascript">
									var postads = <?php echo json_encode($adspost) ?>;
									var postadactive = postads[Math.floor(Math.random() * ((postads.length-1)-0 + 1) + 0)] || false;
									if(postadactive){
										document.write('<a href="'+postadactive.link+'">'+postadactive.content+'</a>');
									}
							</script>
						</div>

                    </div>
                </aside>

            </div>
        </div>

	</div>
    <!--Pie de Pagina-->
<?php require THEME_PATH.'/parts/footer.php' ?>
