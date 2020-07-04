<?php
	namespace wecor;

	$actualid = (INT) routes::$params[1];

	//Obtenemos los datos del elemento a editar
	$actualudata = ad::getGroup([
		'id' => $actualid,
		'columns' => [
			'ag.id',
			'ag.name',
			'ag.descrip',
			'ag.state',
		]
	]);

	//Si no se encuentra el elemento mostramos la pagina de error
	if( !count($actualudata) ) event::fire('e404');

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];

		if( isset( $_POST['name'], $_POST['descrip'], $_POST['state'] ) ){

			$postdata = [
				'name' => $_POST['name'],
				'descrip' => $_POST['descrip'],
				'state' => $_POST['state'],
			];

			$result = ad::updateGroup($actualid, $postdata);
			if( $result ) $state['state'] = 1;
		}

		echo json_encode($state);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form class="container cont-700 cont-white mg-sec simpleform" id="form-postcreate" method="post" action="?guardar">
		<h1><span class="icon-certificate"></span> Editar grupo de anuncios</h1>
		<div class="form-sec">
			<label for="name">Nombre</label>
			<input type="text" name="name" id="name" class="form-in" value="<?php echo $actualudata['name'] ?>" />
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
		<button type="submit" class="btn btn-primary size-l">Enviar</button>
	</form>
	<script>
	document.querySelector("#form-postcreate").addEventListener('submit', function(e){
		<?php event::fire('adGroupSubmit'); ?>
	});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
