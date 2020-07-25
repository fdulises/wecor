<?php
	namespace wecor;

	//Definimos datos para la paginacion
	$per_page = 20;
	$current_page = isset($_GET['p']) ? (INT) $_GET['p'] : 1;
	$offset = $per_page*($current_page-1);

	//Obtenemos lista de elementos
	$lista = extras::htmlentities(post::getList(array(
		'columns' => [
			'p.id', 'p.title', 'p.slug', 'p.descrip', 'p.updated', 'p.autor', 'p.state', 'p.coverlocal'
		],
		'limit' => $per_page,
		'offset' => $offset,
		'order' => 'p.id ASC',
		'type' => 'post'
	)));
	//Agregamos datos extra a los elementos de la lista
	foreach($lista as $k => $v){
		//Definimos el link de cada elemento
		$lista[$k]['link'] = config::get('site_url').'/'.$v['slug'];

		if( $v['coverlocal'] ){
			$lista[$k]['cover'] = config::get('site_url').'/media/covers/'.$v['coverlocal'];
		}else $lista[$k]['cover'] = config::get('site_url').'/media/covers/default.jpg';
	}

	//Generamos la paginacion
	$pagination = user::pagination([
		'per_page' => $per_page,
		'current_page' => $current_page,
	]);

	site::setMeta( 'title', config::get('site_descrip') );
	site::setMeta( 'description', config::get('site_descrip') );
	site::setMeta( 'pagelink', config::get('site_url') );

	require THEME_PATH.'/parts/header.php';
?>
	<div id="" class="pd-sec bg-blue bg-animated">
		<div class="container">
			<h1 class="tx-center">Bienvenido a <?php echo config::get('site_title') ?></h1>
			<div class="tx-center">
				<p><?php echo config::get('site_descrip') ?></p>
			</div>
		</div>
	</div>
	<div class="bg-default pd-sec">
		<div class="container">
			<div class="container d-flex">
				<?php foreach( $lista as $c ): ?>
				<div class="gd-50 gd-m-100 gd-b-50 card tx-center">
					<a href="<?php echo $c['link'] ?>" class="card-frame">
						<img src="<?php echo $c['cover'] ?>" alt="<?php echo $c['title'] ?>">
						<div class="card-title"><?php echo $c['title'] ?></div>
						<p><?php echo $c['descrip'] ?></p>
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
		<?php if( $pagination->hasNext() ): ?>
		<a href='<?php echo $pagination->result('next_page_url'); ?>'>Siguiente &raquo;</a>
		<?php endif; ?>
	</div>
<?php require THEME_PATH.'/parts/footer.php' ?>
