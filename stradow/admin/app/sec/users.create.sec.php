<?php
	namespace wecor;

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];

		if( isset( $_POST['name'], $_POST['nickname'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['descrip'] ) ){
			$result = user::register([
				'name' => $_POST['name'],
				'nickname' => $_POST['nickname'],
				'email' => $_POST['email'],
				'password' => $_POST['password'],
				'role' => $_POST['role'],
				'descrip' => $_POST['descrip'],
			]);
			if( $result ){
				$state['state'] = 1;
				$state['data']['id'] = $result;
			}else $state['error'] = user::$error;
		}

		echo json_encode($state);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form class="container cont-700 cont-white mg-sec" id="form-usercreate" method="post" action="?guardar">
		<h1><span class="icon-users"></span> Crear usuario</h1>
		<div class="form-sec">
			<label for="name">Nombre</label>
			<input type="text" name="name" id="name" class="form-in" />
		</div>
		<div class="form-sec">
			<label for="nickname">Nickname</label>
			<input type="text" name="nickname" id="nickname" class="form-in" />
		</div>
		<div class="form-sec">
			<label for="email">E-mail</label>
			<input type="email" name="email" id="email" class="form-in" />
		</div>
		<div class="form-sec">
			<label for="password">Contraseña</label>
			<input type="password" name="password" id="password" class="form-in" />
		</div>
		<div class="form-sec">
			<label for="role">Grupo de usuario</label>
			<select name="role" id="role" class="form-in">
				<?php foreach( $groups as $role ): ?>
				<option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="form-sec">
			<label for="descrip">Descripción</label>
			<textarea name="descrip" id="descrip" class="form-in"></textarea>
		</div>
		<button type="submit" class="btn btn-primary size-l">Enviar</button>
	</form>
<?php require APP_SEC_DIR.'/footer.php'; ?>,
