<?php
	namespace wecor;

	$actualid = (INT) routes::$params[1];

	//Obtenemos los datos del elemento a editar
	$actualudata = ad::get([
		'id' => $actualid,
		'columns' => [
			'a.id',
			'a.groupid',
			'a.title',
			'a.link',
			'a.content',
			'a.state',
		]
	]);

	//Si no se encuentra el elemento mostramos la pagina de error
	if( !count($actualudata) ) event::fire('e404');

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];

		if( isset( $_POST['title'], $_POST['link'], $_POST['content'], $_POST['state'] ) ){

			$postdata = [
				'groupid' => $actualudata['groupid'],
				'title' => $_POST['title'],
				'link' => $_POST['link'],
				'content' => $_POST['content'],
				'state' => $_POST['state'],
			];

			$result = ad::update($actualudata['id'], $postdata);
			if( $result ){
				$state['state'] = 1;
				$state['data']['id'] = $result;
			}
		}

		echo json_encode($state);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form class="container cont-700 cont-white mg-sec simpleform" id="form-postcreate" method="post" action="?guardar">
		<h1><span class="icon-certificate"></span> Editar anuncio</h1>
		<div class="form-sec">
			<label for="title">Titulo</label>
			<input type="text" name="title" id="title" class="form-in" value="<?php echo $actualudata['title'] ?>" />
		</div>
		<div class="form-sec">
			<label for="link">Enlace</label>
			<input type="text" name="link" id="link" class="form-in" value="<?php echo $actualudata['link'] ?>" />
		</div>
		<div class="form-sec contenteditor">
			<label for="content">Contenido</label>
			<textarea name="content" id="content" class="form-in"><?php echo $actualudata['content'] ?></textarea>
		</div>
		<div class="form-sec">
			<label for="state">Estado</label>
			<select name="state" id="state" class="form-in" data-selected="<?php echo $actualudata['state'] ?>">
				<option value="1">Activo</option>
				<option value="2">Inactivo</option>
				<option value="0">Eliminado</option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary size-l">Enviar</button>
	</form>
	<script>
	document.querySelector("#form-postcreate").addEventListener('submit', function(e){
		<?php event::fire('postSubmit'); ?>
	});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
