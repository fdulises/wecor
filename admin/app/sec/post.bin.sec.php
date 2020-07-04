<?php
	namespace wecor;

	//Definimos datos para la paginacion
	$per_page = 20;
	$current_page = isset($_GET['p']) ? (INT) $_GET['p'] : 1;
	$offset = $per_page*($current_page-1);

	$data = [
		'columns' => [
			'p.id', 'p.title', 'p.slug', 'p.descrip', 'p.updated', 'p.autor', 'p.state'
		],
		'limit' => $per_page,
		'offset' => $offset,
		'order' => 'p.id DESC',
		'state' => 0,
		'type' => 'post',
	];

	if(isset( $_GET['s'] )){
		$searchstring = extras::htmlentities($_GET['s']);
		$data['search'] = $_GET['s'];
		$data['order'] = 'score DESC';
	}else $searchstring = '';

	//Obtenemos lista de elementos
	$lista = extras::htmlentities(post::getList($data));
	//Agregamos datos extra a los elementos de la lista
	foreach($lista as $k => $v)
		//Definimos el link de cada elemento
		$lista[$k]['link'] = config::get('site_url').'/'.$v['slug'];

	//Generamos la paginacion
	$dpagination = [
		'per_page' => $per_page,
		'current_page' => $current_page,
	];
	if( $searchstring ) $dpagination['url_base'] = '?s='.$searchstring;
	$pagination = post::pagination($dpagination);

	require APP_SEC_DIR.'/header.php';
?>
	<div class="mg-sec container">
		<div class="gd-100">
			<div class="pd-zero gd-60 gd-m-100"><h1><span class="icon-calendar"></span> Entradas eliminadas</h1></div>
			<div class="pd-zero gd-40 gd-m-100 tx-right">
				<a href="<?php echo APP_ROOT; ?>/post/create"><button type="button" class="btn btn-primary"><span class="icon-plus"></span></button></a>
			</div>
		</div>
		<form action="" class="gd-50 gd-s-100 searchbox">
			<input type="text" name="s" value="<?php echo $searchstring ?>" placeholder="Busqueda" class="form-in">
			<button type="submit" class="btn"><span class="icon-search"></span></button>
		</form>
		<div class="listable">
			<div class="container">
				<div class="gd-30 gd-m-50"><h4>Título</h4></div>
				<div class="gd-30 hide-m"><h4>Descripción</h4></div>
				<div class="gd-20 hide-m"><h4>Actualizado</h4></div>
				<div class="gd-20 gd-m-50 tx-right"><h4>Acciones</h4></div>
			</div>
			<?php foreach( $lista as $c ): ?>
				<div class="container">
					<div class="gd-30 gd-m-50">
						<span class="lstatus-<?php echo $c['state']; ?>"></span><?php echo $c['title']; ?>
					</div>
					<div class="gd-30 hide-m">
						<?php echo $c['descrip']; ?>
					</div>
					<div class="gd-20 hide-m">
						<?php echo $c['updated']; ?>
					</div>
					<div class="gd-20 gd-m-50 tx-right">
						<a href="<?php echo APP_ROOT; ?>/post/update/<?php echo $c['id']; ?>"><button class="btn btn-primary size-s"><span class="icon-pencil"></span></button></a>
					</div>
				</div>
			<?php endforeach; ?>
			<?php if (!$lista): ?>
				<div class="alert">
				    <strong>¡Sin entradas!</strong> No se encontrarón resultados.
				</div>
			<?php endif; ?>
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
<?php require APP_SEC_DIR.'/footer.php'; ?>
