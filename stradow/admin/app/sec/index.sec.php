<?php
	namespace wecor;

	$aprofile = extras::htmlentities(user::get([
		'id' => $_SESSION[S_USERID],
		'columns' => [
			'u.id', 'u.nickname', 'u.email', 'up.descrip', 'u.role', 'u.created', 'up.name',
		],
	]));
	$aprofile['avatar'] = extras::urlGravatar($aprofile['email'], 200);

	require APP_SEC_DIR.'/header.php';
?>
<div class="container mg-sec">
	<div class="gd-100 tx-center">
		<h1><span class="icon-home"></span> Bienvenido al panel de <?php echo config::get('site_title') ?></h1>
	</div>
	<div class="container">
		<div class="gd-60 tx-center gd-m-100">
			<div class="container">
				<div class="gd-30 gd-b-100">
					<img src="<?php echo $aprofile['avatar'] ?>" alt="">
				</div>
				<div class="gd-70 gd-b-100">
					<h4 class="">Sesión iniciada como: @<?php echo $aprofile['nickname'] ?></h4>
					<p><?php echo $aprofile['descrip'] ?></p>
					<div class="gd-100">
						<a href="users/update/<?php echo $aprofile['id'] ?>"><button class="btn btn-default btn-block size-l"><span class="icon-prifile"></span> Editar mi perfil</button></a>
					</div>
				</div>
			</div>
			<div class="container mg-sec listable">
				<div class="listable">
					<div class="container">
						<div class="gd-100">
							<h2>Información del sitio</h2>
						</div>
					</div>
					<div class="container tx-left">
						<div class="gd-100">
							<b>Titulo:</b> <?php echo config::get('site_title') ?>
						</div>
					</div>
					<div class="container tx-left">
						<div class="gd-100">
							<b>Descripción:</b> <?php echo config::get('site_descrip') ?>
						</div>
					</div>
					<div class="container tx-left">
						<div class="gd-100">
							<b>Dirección:</b> <a href="<?php echo config::get('site_url') ?>"><?php echo config::get('site_url') ?></a>
						</div>
					</div>
				</div>
				<div class="gd-100">
					<a href="config" class="btn"> Editar configuración</a>
				</div>
			</div>
		</div>
		<div class="gd-40 gd-m-100 tx-center">
			<div class="listable">
				<div class="container">
					<h3>Acceso rápido</h3>
				</div>
				<div class="container">
					<div class="gd-100">
						<a href="post/create"><button class="btn btn-primary btn-block"><span class="icon-calendar"></span> Crear entrada</button></a>
					</div>
				</div>
				<div class="container">
					<div class="gd-100">
						<a href="pages/create"><button class="btn btn-primary btn-block"><span class="icon-file-text"></span> Crear página</button></a>
					</div>
				</div>
				<div class="container">
					<div class="gd-100">
						<a href="cats/create"><button class="btn btn-primary btn-block"><span class="icon-bookmark"></span> Crear categoría</button></a>
					</div>
				</div>
				<div class="container">
					<div class="gd-100">
						<a href="users/create"><button class="btn btn-primary btn-block"><span class="icon-users"></span> Crear usuario</button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require APP_SEC_DIR.'/footer.php'; ?>
