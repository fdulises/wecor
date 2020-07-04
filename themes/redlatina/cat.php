<?php
	namespace wecor;

	site::setMeta( 'title', 'The leading spanish-bilingual newspaper' );
	site::setMeta( 'description', 'The leading spanish-bilingual newspaper' );
	site::setMeta( 'pagelink', config::get('site_url') );
	site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );

	$catslug = routes::$params[1];

	//Definimos datos para la paginacion
	$per_page = 20;
	$current_page = isset($_GET['p']) ? (INT) $_GET['p'] : 1;
	$offset = $per_page*($current_page-1);

	//Obtenemos lista de elementos
	$lista = post::getList(array(
		'columns' => [
			'p.id', 'p.title', 'p.slug', 'p.descrip', 'p.updated',
		],
		'limit' => $per_page,
		'offset' => $offset,
		'order' => 'p.id ASC',
		'type' => 'post',
		'lang' => $sitelang,
		'catslug' => $catslug,
	));
	$lista = extras::htmlentities($lista);
	$lista = extras::striptags($lista);

	//Agregamos datos extra a los elementos de la lista
	foreach($lista as $k => $v)
		//Definimos el link de cada elemento
		$lista[$k]['link'] = config::get('site_url').'/'.$v['slug'];

	//Generamos la paginacion
	$pagination = post::pagination([
		'per_page' => $per_page,
		'current_page' => $current_page,
	]);

	//Obtenemos grupo publicitario
	$adsprincipal = ad::getList([
		'groupid' => 1,
		'columns' => [
			'a.id', 'a.title', 'a.link', 'a.state', 'a.content'
		],
		'order' => 'id ASC',
	]);

	require THEME_PATH.'/parts/header.php';
?>
      <!---contenedor principal del sitio.-->
      <main class="cont-main" id="contMain" data-state="hide">
        <!---Estructura inicial-->
        <div class="mg-sec container">
            <div class="mg-sec pd-sec">
				<h3 class="tx-center rc-letterneon" id="shooter4"><?php echo $extras['news'] ?></h3>
				<div class="order-grids">
					<?php foreach( $lista as $c ): ?>
                	<div class="cards-raych-1 gd-50 gd-b-100 gd-s-100 smoove-event4 mg-sec">
                    <div class="sombra">
                        <img src="<?php echo config::get('site_url') ?>/media/covers/<?php echo $c['id']; ?>.jpg"
                            alt="" class="imagenes" />
                        <h4 class="tx-left fnt-black"><?php echo $c['title']; ?></h4>
                        <p>
                            <?php echo $c['descrip']; ?>
                        </p>
						<div class="tx-center">
							<a href="<?php echo config::get('site_url') ?>/<?php echo $c['slug'] ?>"><button class="btn-material indigo-material size-1"><span class="icon-newspaper-o"> <?php echo $extras['postanch'] ?></span></button></a>
						</div>
                    </div>
                	</div>
					<?php endforeach; ?>
				</div>
            </div>
        </div>
    </main>
<?php require THEME_PATH.'/parts/footer.php' ?>
