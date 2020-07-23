<?php
	namespace wecor;

	//Obtenemos el id del elemento a editar
	$actualid = (INT) routes::$params[1];

	//Obtenemos los datos del elemento a editar
	$actualudata = extras::htmlentities(post::get([
		'id' => $actualid,
		'columns' => [
			'p.id',
			'p.title',
			'p.content',
			'p.descrip',
			'p.state',
			'p.slug',
		]
	]));

	//Si no se encuentra el elemento mostramos la pagina de error
	if( !count($actualudata) ) event::fire('e404');

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];
		$data = [];
		if( isset( $_POST['title'] ) ) $data['title'] = $_POST['title'];
		if( isset( $_POST['slug'] ) ) $data['slug'] = $_POST['slug'];
		if( isset( $_POST['content'] ) ) $data['content'] = $_POST['content'];
		if( isset( $_POST['descrip'] ) ) $data['descrip'] = $_POST['descrip'];
		if( isset( $_POST['state'] ) ) $data['state'] = $_POST['state'];
		if( post::update( $actualid, $data ) ) $state['state'] = 1;
		echo json_encode($state);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form id="post-update" class="container cont-700 cont-white mg-sec simpleform" method="post" action="?guardar">
		<h1><span class="icon-calendar"></span> Editar entrada</h1>
		<div class="form-sec">
			<label for="title">Título</label>
			<input type="text" name="title" id="title" class="form-in" value="<?php echo $actualudata['title'] ?>" />
		</div>
		<div class="form-sec">
			<label for="slug">Slug</label>
			<input type="text" name="slug" id="slug" class="form-in" value="<?php echo $actualudata['slug'] ?>" />
		</div>
		<div class="form-sec contenteditor">
			<label for="content">Contenido</label>
			<textarea name="content" id="content" class="form-in"><?php echo $actualudata['content'] ?></textarea>
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
	<script>
	document.querySelector("#post-update").addEventListener('submit', function(e){
		<?php event::fire('postSubmit'); ?>
	});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
