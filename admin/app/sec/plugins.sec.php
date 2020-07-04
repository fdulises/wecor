<?php
	namespace wecor;

	if( isset($_GET['switch']) ){
		$result = ['state' => 0,'data' => [],'error' => [],];

		if( $_GET['switch'] ){
			plugins::toogle( $_GET['switch'] );
			$result['state'] = 1;
		}

		echo json_encode($result, true);
		exit();
	}

	$plugins_list = plugins::getList();

	require APP_SEC_DIR.'/header.php';
?>
	<div class="mg-sec container">
		<div class="gd-100">
			<h1><span class="icon-puzzle-piece"></span> Listado de complementos</h1>
		</div>
		<div class="listable">
			<div class="container">
				<div class="gd-30 gd-m-50"><h4>Nombre</h4></div>
				<div class="gd-50 hide-m"><h4>Descripción</h4></div>
				<div class="gd-20 gd-m-50 tx-right"><h4>Acciones</h4></div>
			</div>
			<?php foreach( $plugins_list as $c ): ?>
			<div class="container">
				<div class="gd-30 gd-m-50">
					<?php echo $c['name'] ?>
				</div>
				<div class="gd-50 hide-m">
					<?php echo $c['descrip'] ?>
				</div>
				<div class="gd-20 gd-m-50 tx-right">
					<?php if( $c['state'] == 0 ): ?>
					<button data-id="<?php echo $c['dir'] ?>" class="btn btn-default btn-primary size-s">Activar</button>
					<?php else: ?>
					<button data-id="<?php echo $c['dir'] ?>" class="btn btn-default size-s">Desactivar</button>
					<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
			<?php if (!$plugins_list): ?>
				<div class="alert">
				    <strong>¡Sin complementos!</strong> No se encontrarón resultados.
				</div>
			<?php endif; ?>
		</div>
	</div>
	<script>
	document.addEventListener("DOMContentLoaded", function(){
		addEvent('button[data-id]', 'click', function(){
			var objetive = this;
			listefi.ajax({
				url: '?switch='+this.getAttribute("data-id"), method: 'get',
				success: function(result){
					if( objetive.innerHTML == "Activar" ) objetive.innerHTML = "Desactivar";
					else objetive.innerHTML = "Activar";
					objetive.classList.toggle("btn-primary");
				},
			});
		});
	});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
