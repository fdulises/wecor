<?php
	namespace wecor;

	if( isset($_GET['dir'],$_GET['name']) ){
		$result = ['state' => 0,'data' => [],'error' => [],];

		if( $_GET['dir'] ){
			themes::set( $_GET['dir'], $_GET['name'] );
			$result['state'] = 1;
		}

		echo json_encode($result, true);
		exit();
	}

	$themes_list = themes::getList();

	require APP_SEC_DIR.'/header.php';
?>
	<div class="mg-sec container">
		<div class="gd-100">
			<h1><span class="icon-paint-brush"></span> Listado de temas</h1>
		</div>
		<?php foreach( $themes_list as $c ): ?>
		<div class="gd-33 gd-m-50 gd-s-100">
			<div class="card">
				<img src="<?php echo $c['url'].'/screenshot.jpg' ?>" class="cover">
				<div class="card-header">
					<h4 class="tx-center"><?php echo $c['name'] ?></h4>
				</div>
				<div class="card-footer tx-center">
					<button data-dir="<?php echo $c['dir'] ?>" data-name="<?php echo $c['name'] ?>" class="btnswitch btn btn-primary<?php if( $c['state'] == 1 ) echo ' hide' ?>">Activar</button>
					<?php /* <button class="btnconfig btn<?php if( $c['state'] == 0 ) echo ' hide' ?>"><span class="icon-cog"></span> Configurar</button>
					<button type="button" class="btnpreview btn"><span class="icon-eye"></span></button>
					*/ ?>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<script>
	var clicked = null;
	document.addEventListener("DOMContentLoaded", function(){
		addEvent('.btnswitch', 'click', function(){
			clicked = this;
			listefi.ajax({
				url: '?dir='+clicked.getAttribute("data-dir")+'&name='+clicked.getAttribute("data-name"), method: 'get',
				success: function(result){
					var passactive = document.querySelector(".btnswitch.hide");
					passactive.classList.remove("hide");
					//passactive.parentNode.querySelector(".btnconfig").classList.add("hide");

					clicked.classList.add("hide");
					//clicked.parentNode.querySelector(".btnconfig").classList.remove("hide");
				},
			});
		});
	});
	</script>
<?php require APP_SEC_DIR.'/footer.php'; ?>
