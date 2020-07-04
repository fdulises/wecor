<?php
	namespace wecor;

	//Obtenemos datos de la entrada principal si existe
	$maindata = [];
	if( isset(routes::$params[1]) ){
		$maindata = extras::htmlentities(post::get([
			'id' => (INT) routes::$params[1],
			'columns' => [
				'p.id',
				'p.title',
				'p.descrip',
				'p.state',
				'p.slug',
				'p.lang',
				'p.verof',
				'p.cat',
			]
		]));
	}

	//Procesamos formulario de guardado
	if( isset($_GET['guardar']) ){
		$state = [ 'state' => 0, 'error' => [], 'data' => [] ];

		if( isset( $_POST['title'], $_POST['slug'], $_POST['content'], $_POST['descrip'] ) ){
			$postdata = [
				'title' => $_POST['title'],
				'slug' => $_POST['slug'],
				'content' => $_POST['content'],
				'descrip' => $_POST['descrip'],
			];
			if( isset($_POST['lang']) ) $postdata['lang'] = $_POST['lang'];
			if( isset($_POST['verof']) ) $postdata['verof'] = (INT) $_POST['verof'];
			$result = post::create($postdata);
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
		<?php if ($maindata): ?>
		<h1><span class="icon-text"></span> Crear traducción para página "<?php echo $maindata['title'] ?>"</h1>
		<?php else: ?>
		<h1><span class="icon-text"></span> Crear página</h1>
		<?php endif; ?>
		<div class="form-sec">
			<label for="title">Título</label>
			<input type="text" name="title" id="title" class="form-in" />
		</div>
		<div class="form-sec">
			<label for="slug">Slug</label>
			<input type="text" name="slug" id="slug" class="form-in" value="<?php if ($maindata) echo $maindata['slug'] ?>" data-slugsuggest="#title" />
		</div>
		<div class="form-sec contenteditor">
			<label for="content">Contenido</label>
			<textarea name="content" id="content" class="form-in"></textarea>
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
		<button type="submit" class="btn btn-primary size-l">Agregar página</button>
	</form>
	<?php if ($maindata): ?>
	<div class="container cont-700 cont-white mg-sec">
		<a href="<?php echo $approot ?>/pages/update/<?php echo $maindata['verof'] ?>"><button type="button" class="btn btn-block size-l">Versión original</button></a>
	</div>
	<?php endif; ?>
	<script>
		document.querySelector("#form-postcreate").addEventListener('submit', function(e){
			e.preventDefault();
			<?php event::fire('postSubmit'); ?>
			listefi.ajax({
				method: 'post',
				url: this.getAttribute('action'),
				data: new FormData(this),
				success: function(result){
					result = JSON.parse(result);
					if( result.state == 1 ){
						location.href = APP_ROOT+'/pages/update/'+result.data.id+'?state=created';
					}else listefi.alert('Ha ocurrido un error al realizar la acción solicitada.', 'Error');
				}
			});
		});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>,
