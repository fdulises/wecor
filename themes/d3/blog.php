<?php
	namespace wecor;

	site::setMeta( 'title', 'Blog' );
	site::setMeta( 'description', 'Todo lo que necesitas saber para empezar y/o mejorar tu proyecto en linea' );
	site::setMeta( 'pagelink', config::get('site_url').'/blog' );
	site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );

	//Definimos datos para la paginacion
	$per_page = 9;
	$current_page = isset($_GET['p']) ? (INT) $_GET['p'] : 1;
	$offset = $per_page*($current_page-1);

	//Obtenemos lista de elementos
	$lista = post::getList(array(
		'columns' => [
			'p.id', 'p.title', 'p.slug', 'p.descrip', 'p.updated', 'p.cover', 'p.coverlocal',
		],
		'limit' => $per_page,
		'offset' => $offset,
		'order' => 'p.id DESC',
		'type' => 'post',
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
	]);

	require THEME_PATH.'/parts/header.php';
?>
	<div id="" class="pd-sec bg-blue">
		<div class="container">
			<h1 class="tx-center">Blog de Debred</h1>
			<div class="tx-center"><?php echo site::getMeta('description') ?></div>
		</div>
	</div>
	<div class="dblog bg-default pd-sec">
		<div class="container">
			<div class="container d-flex">
				<?php foreach( $lista as $c ): ?>
				<div class="gd-33 gd-b-50 gd-s-100 card">
					<a href="<?php echo $c['link'] ?>" class="card-frame">
						<img src="<?php echo $c['postcover'] ?>" class="cover">
						<div class="card-title tx-center"><?php echo $c['title'] ?></div>
						<p><?php echo $c['descrip'] ?></p>
						<p>
							<button type="button" class="btn size-l btn-block btn-default">Seguir leyendo</button>
						</p>
					</a>
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
<?php require THEME_PATH.'/parts/footer.php' ?>
