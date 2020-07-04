<?php
	namespace wecor;

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];

		if( isset( $_POST['name'], $_POST['descrip'], $_POST['state'] ) ){

			$postdata = [
				'name' => $_POST['name'],
				'descrip' => $_POST['descrip'],
				'state' => $_POST['state'],
				'type' => 'custom',
			];
			if( isset($_POST['cat']) ) $postdata['cat'] = (INT) $_POST['cat'];

			$result = ad::createGroup($postdata);
			if( $result ){
				$state['state'] = 1;
				$state['data']['id'] = $result;
			}else $state['error'] = post::$error;
		}

		echo json_encode($state);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form class="container cont-700 cont-white mg-sec" id="form-postcreate" method="post" action="?guardar">
		<h1><span class="icon-certificate"></span> Crear grupo de anuncios</h1>
		<div class="form-sec">
			<label for="name">Nombre</label>
			<input type="text" name="name" id="name" class="form-in" />
		</div>
		<div class="form-sec">
			<label for="descrip">Descripción</label>
			<textarea name="descrip" id="descrip" class="form-in"></textarea>
		</div>
		<div class="form-sec">
			<label for="state">Estado</label>
			<select name="state" id="state" class="form-in">
				<option value="2">Inactivo</option>
				<option value="1">Activo</option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary size-l">Enviar</button>
	</form>
	<script>
	document.querySelector("#form-postcreate").addEventListener('submit', function(e){
		<?php event::fire('postSubmit'); ?>
		e.preventDefault();
		listefi.ajax({
			method: 'post',
			url: this.getAttribute('action'),
			data: new FormData(this),
			success: function(result){
				result = JSON.parse(result);
				console.log(result);
				if( result.state == 1 ){
					location.href = APP_ROOT+'/adsgroups/update/'+result.data.id+'?state=created';
				}else listefi.alert('Ha ocurrido un error al realizar la acción solicitada.', 'Error');
			}
		});
	});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
