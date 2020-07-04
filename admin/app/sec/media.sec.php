<?php
	namespace wecor;

	$basedir = MEDIA_DIR;
	$subdir = '';
	if( isset($_GET['subdir']) ){
		$basedir .= "/{$_GET['subdir']}";
		$subdir = $_GET['subdir'];
	}

	$list_files = media::listDir($basedir);
	foreach ($list_files as $k => $v) {
		if( $v['type'] != 'dir' ) $list_files[$k]['url'] = config::get('site_url')."/media/{$v['url']}";
		else $list_files[$k]['url'] = '';
	}

	if( isset($_GET['read']) ) exit();

	require APP_SEC_DIR.'/header.php';
?>
<div class="container mg-sec">
	<div class="gd-100">
		<h1><span class="icon-folder-open"></span> Gestor de Archivos Multimedia</h1>
	</div>
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="tienda.html">Multimedia</a></li>
		</ul>
	</div>
	<div class="container">
		<div id="mia-bar">
			<button type="button" name="button" class="btn" id="newupinp"><span class="icon-upload"></span> Subir Archivo</button>
			<button type="button" name="button" class="btn" id="newupfolder"><span class="icon-folder"></span> Crear directorio</button>
		</div>
	</div>
	<div class="container d-flex" id="upslist">
		<div class="alert gd-100<?php if( count($list_files) ) echo ' hide'; ?>" id="neup-empty">
			<strong>¡Carpeta vacía!</strong> Aún no se han subido archivos a esta carpeta.
		</div>
		<form id="newup-fcreate" class="gd-25 gd-b-50 gd-m-100 hide">
			<div class="ups-html"><span class="icon-folder-open"></span></div>
			<div>
				<input type="text" name="folname" class="form-in" placeholder="Nombre de la carpeta" />
				<button type="submit" class="btn btn-block btn-primary">Crear Carpeta</button>
			</div>
		</form>
		<?php foreach ($list_files as $v): ?>
		<div class="gd-25 gd-b-50 gd-m-100">
			<?php if ($v['url']): ?>
			<a href="<?php echo $v['url'] ?>" target="_blank">
			<?php endif; ?>
			<h4><span class="<?php echo $v['icon'] ?>"></span> <?php echo $v['name'] ?></h4>
			<div class="ups-html">
				<?php
				if( $v['type'] == 'jpg') echo "<img src='{$v['url']}' />";
				else echo "<span class='{$v['icon']}'></span>";
				?>
			</div>
			<?php if ($v['url']): ?></a><?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<form id="newupform" class="hide" action="" method="post">
	<input type="file" name="newup" value="" id="newup" class="hide">
	<input type="hidden" name="subdir" id="subdir" value="<?php echo $subdir; ?>">
</form>
<style>
#mia-bar{
	padding-bottom: 10px;
}
#upslist [class*="gd-"]{;
	border: 1px solid #ccc;
	padding-top: 15px;
	padding-bottom: 15px;
	border-radius: 5px;
	background-color: #fff;
}
#upslist h4{
	font-size: 16px;
}
#upslist img{
	display: block;
	margin: 0 auto;
	max-height: 200px;
}
.ups-html{
	font-size: 150px;
	text-align: center;
	color: #ccc;
	padding: 10px 0;
}
.ups-html span {
	display: block;
}
</style>
<script>
	var upslist = document.querySelector('#upslist');
	var newup = document.querySelector('#newup');
	var newupform = document.querySelector('#newupform');
	var newupfcreate = document.querySelector('#newup-fcreate');
	var neupempty = document.querySelector('#neup-empty');

	//Algoritmo para creacion de carpetas
	function upsCreateFolder(uri, callback){
		listefi.ajax({
			url: APP_ROOT+'/media/upload', method: 'post',
			data: {
				createdir: uri, subdir: document.querySelector('#subdir').value,
			},
			success: function(result){callback(JSON.parse(result));}
		});
	}
	function upslistInsert(data){
		var listchild = document.createElement("div");
		if( data.type == 'jpg' || data.type == 'png' || data.type == 'gif' || data.type == 'jpeg' )
			data.html = '<img src="'+data.url+'">';
		else data.html = '<span class="'+data.icon+'"></span>';
		listchild.setAttribute("class", "gd-25 gd-b-50 gd-m-100");
		listchild.innerHTML = '<h4><span class="'+data.icon+'"></span> '+data.name+'</h4><div class="ups-html">'+data.html+'</div>';

		upslist.insertBefore(listchild, upslist.querySelector('form+div'));
	}

	//Boton subida de archivo
	document.querySelector('#newupinp').addEventListener('click', function(){
		newup.click();
	});
	newup.addEventListener("change", function(){
		listefi.ajax({
			url: APP_ROOT+'/media/upload', method: 'post',
			data: new FormData(newupform),
			success: function(result){
				result = JSON.parse(result);
				if( result.state == 1 ){
					upslistInsert(result.data);
				}else listefi.alert("Se produjo un error al intentar procesar lo solicitado", "Error");
			}
		});
	});


	//Boton mostrar formulario para crear carpeta
	document.querySelector('#newupfolder').addEventListener("click", function(){
		newupfcreate.classList.remove("hide");
		newupfcreate.folname.focus();
	});

	//Procesamos formulario de creacion de carpetas
	newupfcreate.addEventListener("submit", function(e){
		e.preventDefault();
		upsCreateFolder(newupfcreate.folname.value, function(result){
			if(result.state == 1){
				newupfcreate.classList.add('hide');
				neupempty.classList.add('hide');

				upslistInsert({
					type: 'dir', icon: 'icon-folder-open',
					name: newupfcreate.folname.value
				});
			}else{
				if( in_array('duplicated_dir', result.error) )
					listefi.alert('El destino ya contiene una carpeta llamada "'+newupfcreate.folname.value+'"', "Error");
				else listefi.alert("Se produjo un error al intentar procesar lo solicitado", "Error");
			}
		});
	});

</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
