<?php
	namespace wecor;

	//Obtenemos el id del elemento a editar
	$actualid = (INT) routes::$params[1];

	//Obtenemos los datos del elemento a editar
	$actualudata = extras::htmlentities(cat::get([
		'id' => $actualid,
		'columns' => [
			'id',
			'title',
			'descrip',
			'state',
			'slug',
			'lang',
			'verof',
		]
	]));

	//Si no se encuentra el elemento mostramos la pagina de error
	if( !count($actualudata) ) event::fire('e404');

	//Obtenemos lista de traducciones
	$mllist = extras::htmlentities(cat::getList([
		'columns' => [
			'c.id',
			'c.lang',
			'c.title',
		],
		'order' => 'c.lang',
		'verof' => $actualudata['verof'],
	]));

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];
		$data = [];
		if( isset( $_POST['title'] ) ) $data['title'] = $_POST['title'];
		if( isset( $_POST['slug'] ) ) $data['slug'] = $_POST['slug'];
		if( isset( $_POST['descrip'] ) ) $data['descrip'] = $_POST['descrip'];
		if( isset( $_POST['state'] ) ) $data['state'] = $_POST['state'];
		if( isset( $_POST['lang'] ) ) $data['lang'] = $_POST['lang'];
		if( cat::update( $actualid, $data ) ) $state['state'] = 1;
		echo json_encode($state);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form id="cat-update" class="container cont-700 cont-white mg-sec simpleform" method="post" action="?guardar">
		<h1><span class="icon-bookmark"></span> Editar categoría</h1>
		<div class="form-sec">
			<label for="title">Titulo</label>
			<input type="text" name="title" id="title" class="form-in" value="<?php echo $actualudata['title'] ?>" />
		</div>
		<div class="form-sec">
			<label for="slug">Slug</label>
			<input type="text" name="slug" id="slug" class="form-in" value="<?php echo $actualudata['slug'] ?>" data-slugsuggest="#title" />
		</div>
		<div class="form-sec">
			<label for="descrip">Descripción</label>
			<textarea name="descrip" id="descrip" class="form-in"><?php echo $actualudata['descrip'] ?></textarea>
		</div>
		<div class="form-sec">
			<label for="lang">Idioma</label>
			<select class="form-in" name="lang" id="lang" data-selected="<?php echo $actualudata['lang'] ?>">
				<?php foreach ($lagslist as $k => $v): ?>
					<option value="<?php echo $k ?>"><?php echo $v ?></option>
				<?php endforeach; ?>
			</select>
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
	<div class="container cont-700">
		<div class="listable">
			<div class="container">
				<div class="gd-100">
					<h3>Traducciones</h3>
				</div>
			</div>
			<div class="container">
				<?php if (!$mllist): ?>
					<div class="alert">
						Aún no se han agregado traducciones para esta categoría
					</div>
				<?php endif; ?>
			</div>

			<?php foreach( $mllist as $c ): ?>
			<div class="container">
				<div class="gd-40 gd-m-50">
					<?php echo $c['title']; ?>
				</div>
				<div class="gd-40 hide-m">
					<?php echo $c['lang']; ?>
				</div>
				<div class="gd-20 gd-m-50 tx-right">
					<a href="<?php echo $approot ?>/cats/update/<?php echo $c['id']; ?>"><button class="btn btn-primary size-s"><span class="icon-pencil"></span></button></a>
				</div>
			</div>
			<?php endforeach; ?>

			<a href="<?php echo $approot ?>/cats/create/<?php echo $actualudata['verof'] ?>"><button type="button" class="btn btn-acent size-l">Añadir traducción</button></a>
		</div>

	</div>
	<script>
	document.querySelector("#cat-update").addEventListener('submit', function(e){
		<?php event::fire('catSubmit'); ?>
	});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
