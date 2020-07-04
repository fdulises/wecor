<?php
	namespace wecor;

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];

		if( isset( $_POST['title'], $_POST['slug'], $_POST['content'], $_POST['descrip'] ) ){
			$result = post::create([
				'title' => $_POST['title'],
				'slug' => $_POST['slug'],
				'content' => $_POST['content'],
				'descrip' => $_POST['descrip'],
				'type' => 'code',
			]);
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
		<h1><span class="icon-calendar"></span> Crear entrada</h1>
		<div class="form-sec">
			<label for="title">Título</label>
			<input type="text" name="title" id="title" class="form-in" />
		</div>
		<div class="form-sec">
			<label for="slug">Slug</label>
			<input type="text" name="slug" id="slug" class="form-in" />
		</div>
		<div class="form-sec contenteditor">
			<label for="content">Contenido</label>
			<textarea name="content" id="content" class="form-in"></textarea>
		</div>
		<div class="form-sec">
			<label for="descrip">Descripción</label>
			<textarea name="descrip" id="descrip" class="form-in"></textarea>
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
				if( result.state == 1 ){
					location.href = APP_ROOT+'/code/update/'+result.data.id+'?state=created';
				}else listefi.alert('Ha ocurrido un error al realizar la acción solicitada.', 'Error');
			}
		});
	});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
