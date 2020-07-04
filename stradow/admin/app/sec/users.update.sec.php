<?php
	namespace wecor;

	//Obtenemos el id del elemento a editar
	$actualid = (INT) routes::$params[1];

	//Obtenemos los datos del elemento a editar
	$actualudata = extras::htmlentities(user::get([
		'id' => $actualid,
		'columns' => [
			'u.id',
			'u.nickname',
			'u.email',
			'u.state',
			'u.role',
			'up.name',
			'up.descrip',
		]
	]));

	//Si no se encuentra el elemento mostramos la pagina de error
	if( !count($actualudata) ) event::fire('e404');

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];
		$data = [];
		if( isset( $_POST['nickname'] ) ) $data['nickname'] = $_POST['nickname'];
		if( isset( $_POST['email'] ) ) $data['email'] = $_POST['email'];
		if( isset( $_POST['role'] ) ) $data['role'] = (int) $_POST['role'];
		if( isset( $_POST['state'] ) ) $data['state'] = (int) $_POST['state'];
		if( isset( $_POST['name'] ) ) $data['up.name'] = $_POST['name'];
		if( user::update( $actualid, $data ) ) $state['state'] = 1;
		echo json_encode($state);
		exit();
	}else if( isset( $_GET['passchange'] ) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];
		$data = [];

		if( isset($_POST['password']) ){
			$result = user::passchange([
				'id' => $actualid,
				'password' => $_POST['password'],
			]);
			if( $result ) $state['state'] = 1;
		}

		echo json_encode($state);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form class="container cont-700 cont-white mg-sec simpleform" method="post" action="?guardar">
		<h1><span class="icon-users"></span> Editar usuario</h1>
		<div class="form-sec">
			<label for="name">Nombre</label>
			<input type="text" name="name" id="name" class="form-in" value="<?php echo $actualudata['name'] ?>" />
		</div>
		<div class="form-sec">
			<label for="nickname">Nickname</label>
			<input type="text" name="nickname" id="nickname" class="form-in" value="<?php echo $actualudata['nickname'] ?>" />
		</div>
		<div class="form-sec">
			<label for="email">E-mail</label>
			<input type="text" name="email" id="email" class="form-in" value="<?php echo $actualudata['email'] ?>" />
		</div>
		<div class="form-sec">
			<label for="role">Grupo de usuario</label>
			<select name="role" id="role" class="form-in" data-selected="<?php echo $actualudata['role'] ?>">
				<?php foreach( $groups as $role ): ?>
				<option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-sec">
			<label for="descrip">Descripción</label>
			<textarea name="descrip" id="descrip" class="form-in"><?php echo $actualudata['descrip'] ?></textarea>
		</div>
		<div class="form-sec">
			<label for="state">Estado</label>
			<select name="state" id="state" class="form-in" data-selected="<?php echo $actualudata['state'] ?>">
				<option value="2">Inactivo</option>
				<option value="1">Activo</option>
				<option value="0">Eliminado</option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary size-l">Guardar Cambios</button>
	</form>
	<!--Formulario Cambiar contraseña----------------->
	<form class="container cont-700 cont-white mg-sec" method="post" action="?passchange" id="passchange">
		<h2><span class="icon-key"></span> Cambiar Contraseña</h2>
		<div class="form-sec">
			<label for="password">Contraseña Nueva</label>
			<input type="password" name="password" id="password" class="form-in"/>
		</div>
		<div class="form-sec">
			<label for="repass">Confirmar Contraseña</label>
			<input type="password" name="repass" id="repass" class="form-in"/>
		</div>
		<button type="submit" class="btn btn-primary size-l">Actualizar Contraseña</button>
	</form>
<?php require APP_SEC_DIR.'/footer.php'; ?>
