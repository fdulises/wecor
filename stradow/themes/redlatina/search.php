<?php
	namespace wecor;

	site::setMeta( 'title', 'The leading spanish-bilingual newspaper' );
	site::setMeta( 'description', 'The leading spanish-bilingual newspaper' );
	site::setMeta( 'pagelink', config::get('site_url') );
	site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );

	//Definimos datos para la paginacion
	$per_page = 20;
	$current_page = isset($_GET['p']) ? (INT) $_GET['p'] : 1;
	$offset = $per_page*($current_page-1);

	$search = isset( $_GET['s'] ) ? $_GET['s'] : '';

	//Obtenemos lista de elementos
	$lista = post::getList(array(
		'columns' => [
			'p.id', 'p.title', 'p.slug', 'p.descrip', 'p.updated', 'p.cover', 'p.coverlocal',
		],
		'limit' => $per_page,
		'offset' => $offset,
		'type' => 'post',
		'lang' => $sitelang,
		'search' => $search,
		'order' => 'score DESC',
	));
	$lista = extras::striptags($lista);
	$lista = extras::htmlentities($lista);
	//Agregamos datos extra a los elementos de la lista
	foreach($lista as $k => $v){
		//Definimos el link de cada elemento
		$lista[$k]['link'] = config::get('site_url').'/'.$v['slug'];
		//Definimos la imagen de portada de cada elemento
		$lista[$k]['postcover'] = post::getPostCover($v);
	}

	//Generamos la paginacion
	$pagination = post::pagination([
		'per_page' => $per_page,
		'current_page' => $current_page,
		'url_base' => 'search?s=' .htmlentities($search)
	]);


	require THEME_PATH.'/parts/header.php';
?>
      <!---contenedor principal del sitio.-->
      <main class="cont-main" id="contMain" data-state="hide">
        <!---Estructura inicial-->
        <div class="mg-sec container">
            <div class="mg-sec pd-sec">
				<div class="container">
					<h3 class="tx-center rc-letterneon" id="shooter4"><?php echo $extras['news'] ?></h3>
					<div class="order-grids">
					<?php foreach( $lista as $c ): ?>
	                	<div class="cards-raych-1 gd-50 gd-b-100 gd-s-100 smoove-event4 mg-sec">
	                    <div class="sombra">
	                        <img src="<?php echo $c['postcover']; ?>"
	                            alt="" class="imagenes" />
	                        <h4 class="tx-left fnt-black"><?php echo $c['title']; ?></h4>
	                        <p>
	                            <?php echo event::apply('rem_unshort', $c['descrip']); ?>
	                        </p>
							<div class="tx-center">
								<a href="<?php echo config::get('site_url') ?>/<?php echo $c['slug'] ?>"><button class="btn-material indigo-material size-1"><span class="icon-newspaper-o"> <?php echo $extras['postanch'] ?></span></button></a>
							</div>
	                    </div>
	                </div>
					<?php endforeach; ?>
					</div>
				</div>
				<div class="pagination_s1">
					<?php if( $pagination->hasPrev() ): ?>
					<a href='<?php echo $pagination->result('prev_page_url'); ?>'>&laquo; Anterior</a>
					<?php endif; ?>
					<?php echo $pagination->getLinks(); ?>
					<?php if( $pagination->hasNext() ): ?>
					<a href='<?php echo $pagination->result('next_page_url'); ?>'>Siguiente &raquo;</a>
					<?php endif; ?>
				</div>
            </div>

        </div>
    </main>
<?php require THEME_PATH.'/parts/footer.php' ?>
