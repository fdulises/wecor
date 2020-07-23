<?php
	namespace wecor;

	//Definimos datos para la paginacion
	$per_page = 20;
	$current_page = isset($_GET['p']) ? (INT) $_GET['p'] : 1;
	$offset = $per_page*($current_page-1);

	//Obtenemos lista de elementos
	$lista = extras::htmlentities(post::getList(array(
		'columns' => [
			'p.id', 'p.title', 'p.slug', 'p.descrip', 'p.updated', 'p.autor', 'p.state'
		],
		'limit' => $per_page,
		'offset' => $offset,
		'order' => 'p.id ASC',
		'type' => 'post'
	)));
	//Agregamos datos extra a los elementos de la lista
	foreach($lista as $k => $v)
		//Definimos el link de cada elemento
		$lista[$k]['link'] = config::get('site_url').'/'.$v['slug'];

	//Generamos la paginacion
	$pagination = user::pagination([
		'per_page' => $per_page,
		'current_page' => $current_page,
	]);

	site::setMeta( 'title', 'Documentación' );
	site::setMeta( 'description', 'Comienza a desarrollar con Stradow' );
	site::setMeta( 'pagelink', config::get('site_url').'/'.routes::$params[0] );

	require THEME_PATH.'/parts/header.php';
?>
	<div id="" class="pd-sec bg-blue">
		<div class="container">
			<h1 class="tx-center">Documentación</h1>
			<div class="tx-center">
				<p>Comienza a desarrollar con Stradow.</p>
			</div>
		</div>
	</div>
	<div class="bg-default pd-sec">
		<div class="container">
			<div class="container d-flex">
				<?php foreach( $lista as $c ): ?>
				<div class="gd-33 gd-b-50 gd-s-100 card">
					<a href="<?php echo $c['link'] ?>" class="card-frame">
						<div class="card-title tx-center"><?php echo $c['title'] ?></div>
						<?php echo $c['descrip'] ?>
						<p>
							<button class="btn size-l btn-block btn-default" type="button">Seguir leyendo</button>
						</p>
					</a>
				</div>
				<?php endforeach; ?>
			</div>
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
<?php require THEME_PATH.'/parts/footer.php' ?>
