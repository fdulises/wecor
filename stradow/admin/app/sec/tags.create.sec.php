<?php
	namespace wecor;

	//Obtenemos datos de la entrada principal si existe
	$maindata = [];
	if( isset(routes::$params[1]) ){
		$maindata = extras::htmlentities(cat::get([
			'id' => (INT) routes::$params[1],
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
	}

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];

		if( isset( $_POST['title'], $_POST['slug'], $_POST['descrip'] ) ){
			$data = [
				'title' => $_POST['title'],
				'slug' => $_POST['slug'],
				'descrip' => $_POST['descrip'],
			];
			if( isset($_POST['lang']) ) $data['lang'] = $_POST['lang'];
			if( isset($_POST['verof']) ) $data['verof'] = $_POST['verof'];
			$result = cat::create($data);
			if( $result ){
				$state['state'] = 1;
				$state['data']['id'] = $result;
			}else $state['error'] = cat::$error;
		}

		echo json_encode($state);
		exit();
	}

	require APP_SEC_DIR.'/header.php';
?>
	<form class="container cont-700 cont-white mg-sec" id="form-catcreate" method="post" action="?guardar">
		<?php if ($maindata): ?>
		<h1><span class="icon-bookmark"></span> Crear traducción para categoría "<?php echo $maindata['title'] ?>"</h1>
		<?php else: ?>
		<h1><span class="icon-bookmark"></span> Crear nueva categoría</h1>
		<?php endif; ?>
		<div class="form-sec">
			<label for="name">Titulo</label>
			<input type="text" name="title" id="title" class="form-in" />
		</div>
		<div class="form-sec">
			<label for="slug">Slug</label>
			<input type="text" name="slug" id="slug" class="form-in" value="<?php if ($maindata) echo $maindata['slug'] ?>" data-slugsuggest="#title" />
		</div>
		<div class="form-sec">
			<label for="descrip">Descripción</label>
			<textarea name="descrip" id="descrip" class="form-in"></textarea>
		</div>
		<div class="form-sec">
			<label for="lang">Idioma</label>
			<select class="form-in" name="lang" id="lang">
				<?php foreach ($lagslist as $k => $v): ?>
					<option value="<?php echo $k ?>"><?php echo $v ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php if ($maindata): ?>
		<input type="hidden" name="verof" value="<?php echo $maindata['verof'] ?>" />
		<?php endif; ?>
		<button type="submit" class="btn btn-primary size-l">Crear categoría</button>
	</form>
	<?php if ($maindata): ?>
	<div class="container cont-700 cont-white mg-sec">
		<a href="<?php echo $approot ?>/cats/update/<?php echo $maindata['verof'] ?>"><button type="button" class="btn btn-block size-l">Versión original</button></a>
	</div>
	<?php endif; ?>
	<script>
		document.querySelector("#form-catcreate").addEventListener('submit', function(e){
			e.preventDefault();
			<?php event::fire('catSubmit'); ?>
			listefi.ajax({
				method: 'post',
				url: this.getAttribute('action'),
				data: new FormData(this),
				success: function(result){
					result = JSON.parse(result);
					if( result.state == 1 ){
						location.href = APP_ROOT+'/cats/update/'+result.data.id+'?state=created';
					}else listefi.alert('Ha ocurrido un error al realizar la acción solicitada.', 'Error');
				}
			});
		});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>,
