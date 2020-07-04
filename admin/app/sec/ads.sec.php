<?php
	namespace wecor;

	$actualid = (INT) routes::$params[1];

	$adgroup = ad::getGroup([
		'id' => $actualid,
		'columns' => [
			'ag.id',
			'ag.name',
			'ag.descrip',
			'ag.state',
		]
	]);

	//Definimos datos para la paginacion
	$per_page = 20;
	$current_page = isset($_GET['p']) ? (INT) $_GET['p'] : 1;
	$offset = $per_page*($current_page-1);

	//Obtenemos lista de elementos
	$lista = extras::htmlentities(ad::getList(array(
		'groupid' => $adgroup['id'],
		'columns' => [
			'a.id', 'a.title', 'a.link', 'a.state'
		],
		'limit' => $per_page,
		'offset' => $offset,
		'order' => 'id ASC',
	)));

	//Generamos la paginacion
	$pagination = cat::pagination([
		'per_page' => $per_page,
		'current_page' => $current_page,
	]);

	require APP_SEC_DIR.'/header.php';
?>
	<div class="mg-sec container">
		<div class="gd-100">
			<div class="pd-zero gd-60 gd-m-100"><h1><span class="icon-certificate"></span> Anuncios: <?php echo $adgroup['name'] ?></h1></div>
			<div class="pd-zero gd-40 gd-m-100 tx-right">
				<a href="<?php echo APP_ROOT; ?>/ads/create/<?php echo $adgroup['id'] ?>"><button type="button" class="btn btn-primary"><span class="icon-plus"></span></button></a>
			</div>
		</div>
		<div class="listable">
			<div class="container">
				<div class="gd-33 gd-m-50"><h4>Titulo</h4></div>
				<div class="gd-33 hide-m"><h4>Descripción</h4></div>
				<div class="gd-33 gd-m-50 tx-right"><h4>Acciones</h4></div>
			</div>
			<?php foreach( $lista as $c ): ?>
				<div class="container">
					<div class="gd-33 gd-m-50">
						<?php echo $c['title']; ?>
					</div>
					<div class="gd-33 hide-m">
						<?php echo $c['link']; ?>
					</div>
					<div class="gd-33 gd-m-50 tx-right">
						<a href="../ads/update/<?php echo $c['id']; ?>"><button class="btn btn-primary size-s"><span class="icon-pencil"></span></button></a>
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
<?php require APP_SEC_DIR.'/footer.php'; ?>
