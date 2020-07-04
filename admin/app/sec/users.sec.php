<?php
	namespace wecor;

	//Definimos datos para la paginacion
	$per_page = 20;
	$current_page = isset($_GET['p']) ? (INT) $_GET['p'] : 1;
	$offset = $per_page*($current_page-1);

	//Obtenemos lista de elementos
	$lista = extras::htmlentities(user::getList(array(
		'columns' => [
			'id', 'nickname', 'email', 'role', 'created'
		],
		'limit' => $per_page,
		'offset' => $offset,
		'order' => 'created ASC',
	)));
	//Agregamos datos extra a los elementos de la lista
	foreach($lista as $k => $v){
		//Definimos el link de cada elemento
		$lista[$k]['link'] = config::get('site_url').'/@'.$v['nickname'];
		//Definimos el avatar de cada elemento
		$lista[$k]['avatar'] = extras::urlGravatar($v['email'], 20);
	}
	//Generamos la paginacion
	$pagination = user::pagination([
		'per_page' => $per_page,
		'current_page' => $current_page,
	]);

	require APP_SEC_DIR.'/header.php';
?>
	<div class="mg-sec container">
		<div class="gd-100">
			<div class="pd-zero gd-60 gd-m-100"><h1><span class="icon-users"></span> Listado de usuarios</h1></div>
			<div class="pd-zero gd-40 gd-m-100 tx-right">
				<a href="<?php echo APP_ROOT; ?>/users/create"><button type="button" class="btn btn-primary"><span class="icon-plus"></span></button></a>
			</div>
		</div>
		<div class="listable">
			<div class="container">
				<div class="gd-30 gd-m-50"><h4>Nickname</h4></div>
				<div class="gd-30 hide-m"><h4>Grupo</h4></div>
				<div class="gd-20 hide-m"><h4>E-mail</h4></div>
				<div class="gd-20 gd-m-50 tx-right"><h4>Acciones</h4></div>
			</div>
			<?php foreach( $lista as $c ): ?>
				<div class="container">
					<div class="gd-30 gd-m-50">
						<img class="avatar" src="<?php echo $c['avatar']; ?>" /> <?php echo $c['nickname']; ?>
					</div>
					<div class="gd-30 hide-m">
						<span class="icon-users"></span> <?php echo $groups[$c['role']]['name']; ?>
					</div>
					<div class="gd-20 hide-m">
						<?php echo $c['email']; ?>
					</div>
					<div class="gd-20 gd-m-50 tx-right">
						<a href="users/update/<?php echo $c['id']; ?>"><button class="btn btn-primary size-s"><span class="icon-pencil"></span></button></a>
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
