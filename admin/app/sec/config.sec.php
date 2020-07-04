<?php
	namespace wecor;

	if( isset($_GET['guardar']) ){
		$result = [
			'state'=>0,
			'error'=>[],
			'data'=>[],
		];

		$data = [];
		$query = false;

		$data['site_title'] = isset($_POST['site_title']) ? $_POST['site_title'] : '';
		$data['site_descrip'] = isset($_POST['site_descrip']) ? $_POST['site_descrip'] : '';
		$data['site_url'] = isset($_POST['site_url']) ? $_POST['site_url'] : '';
		$data['site_email'] = isset($_POST['site_email']) ? $_POST['site_email'] : '';
		$data['site_lang'] = isset($_POST['site_lang']) ? $_POST['site_lang'] : 'es';
		$data['site_langmulti'] = isset($_POST['site_langmulti']) ? $_POST['site_langmulti'] : 0;
		$data['site_login_attempts'] = isset($_POST['site_login_attempts']) ? (INT) $_POST['site_login_attempts'] : 0;

		if( !filter_var($data['site_url'],FILTER_VALIDATE_URL) ) $result['error'][] = "ERROR_URL";
		if( !filter_var($data['site_email'],FILTER_VALIDATE_EMAIL) ) $result['error'][] = "ERROR_EMAIL";

		if( !count($result['error']) ) $query = config::set($data);

		if( $query ) $result['state'] = 1;

		echo json_encode($result);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form action="?guardar" method="post" class="container cont-white cont-700 simpleform">
		<h1><span class="icon-cog"></span> Configuración del sitio</h1>
		<div class="form-sec">
			<label for="site_title">Titulo</label>
			<input type="text" name="site_title" value="<?php echo config::get('site_title') ?>" class="form-in" id="site_title">
		</div>
		<div class="form-sec">
			<label for="site_descrip">Descripcion</label>
			<textarea name="site_descrip" class="form-in" id="descrip"><?php echo config::get('site_descrip') ?></textarea>
		</div>
		<div class="form-sec">
			<label for="site_url">Dirección</label>
			<input type="text" name="site_url" value="<?php echo config::get('site_url') ?>" class="form-in" id="url">
		</div>
		<div class="form-sec">
			<label for="site_email">Correo</label>
			<input type="text" name="site_email" value="<?php echo config::get('site_email') ?>" class="form-in" id="email">
		</div>
		<div class="form-sec">
			<label for="site_lang">Idioma por defecto</label>
			<select class="form-in" name="site_lang" id="site_lang" data-selected="<?php echo config::get('site_lang') ?>">
				<?php foreach ($lagslist as $k => $v): ?>
					<option value="<?php echo $k ?>"><?php echo $v ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-sec">
			<label for="site_langmulti">Opciones multi-idioma</label>
			<select class="form-in" name="site_langmulti" id="site_langmulti" data-selected="<?php echo config::get('site_langmulti') ?>">
					<option value="0">Deshabilitadas</option>
					<option value="1">Habilitadas</option>
			</select>
		</div>
		<div class="form-sec">
			<label for="site_login_attempts">Intentos de inicio de sesión permitidos</label>
			<input type="text" name="site_login_attempts" value="<?php echo config::get('site_login_attempts') ?>" class="form-in" id="site_login_attempts">
		</div>
		<button type="submit" name="button" class="btn btn-primary">Guardar Cambios</button>
	</form>
<?php require APP_SEC_DIR.'/footer.php'; ?>
