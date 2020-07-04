<?php
	namespace wecor;

	if( isset($_GET['contactar']) ){
		$result = [
			'state' => 0,
			'data' => [],
			'error' => [],
		];

		if( isset($_POST['nombre'], $_POST['email'], $_POST['asunto'], $_POST['mensaje']) ){
			if( empty($_POST['nombre']) ) $result['error'][] = 'nombre_vacio';
			if( empty($_POST['email']) ) $result['error'][] = 'email_vacio';
			if( empty($_POST['asunto']) ) $result['error'][] = 'asunto_vacio';
			if( empty($_POST['mensaje']) ) $result['error'][] = 'mensaje_vacio';
		}

		if( !$result['error'] ){
			$_POST = extras::htmlentities($_POST);

			$mensaje = "<p><b>Datos del mensaje:</b></p>";
			$mensaje .= "<p> <b>Nombre:</b> {$_POST['nombre']}</p>";
			$mensaje .= "<p> <b>E-mail:</b> {$_POST['email']}</p>";
			$mensaje .= "<p> <b>Telefono:</b> {$_POST['telefono']}</p>";
			$mensaje .= "<p> <b>Asunto:</b> {$_POST['asunto']}</p>";
			$mensaje .= "<p> <b>Mensaje:</b> ".nl2br($_POST['mensaje'])."</p>";

			$envio = mail::phpMail([
				'destino' => 'contacto@debred.com',
				'asunto' => 'Contacto desde sitio web '.config::get('titulo'),
				'mensaje' => $mensaje,
				'from' => 'contacto@debred.com',
				'bcc' => 'fdulises@outlook.com, ulises@debred.com',
			]);
			if( $envio ) $result['state'] = 1;
		}

		echo json_encode($result);
		exit();
	}

	site::setMeta( 'title', 'Página de Contacto' );
	site::setMeta( 'description', 'Queremos saber acerca de tu proyecto, para mandarnos un mensaje completa el formulario de contacto o escríbenos directamente a nuestro e-mail, te responderemos pronto' );
	site::setMeta( 'pagelink', config::get('site_url').'/contacto' );
	site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );

	require THEME_PATH.'/parts/header.php';
?>
	
		<main>
		<div class="pd-sec">
			<div class="container cont-600">
				<div class="tx-center">
					<h2 class="tx-center rc-letterneon"><?php echo $services['tittle'] ?></h2>
					<p><?php echo $services['firstpara'] ?></p>
					<p><?php echo $services['secondpara'] ?></p>
				</div>
			</div>
		</div>
		<div class="pd-sec">
			<form class="cont-600 container" method="post" action="">
				<div class="cont-input">
					<input type="text" class="input-material" name="nombre" required />
					<span class="highlight highlight-blue"></span>
					<span class="bar bar-blue"></span>
					<label class="blue icon-user-o label-material"> <?php echo $services['firtinput'] ?></label>
				</div>
				<div class="cont-input">
					<input type="email" class="input-material" name="email" required />
					<span class="highlight highlight-blue"></span>
					<span class="bar bar-blue"></span>
					<label class="blue icon-envelope-o label-material"> <?php echo $services['secondinput'] ?></label>
				</div>
				<div class="cont-input">
					<input type="asunto" class="input-material" name="asunto" required />
					<span class="highlight highlight-blue"></span>
					<span class="bar bar-blue"></span>
					<label class="blue icon-file-text-o label-material"> <?php echo $services['thirdinput'] ?></label>
				</div>
				<div class="cont-input">
					<input type="text" class="input-material" name="telefono" required />
					<span class="highlight highlight-blue"></span>
					<span class="bar bar-blue"></span>
					<label class="blue icon-phone-square label-material"> <?php echo $services['fourthinput'] ?></label>
				</div>
				<div class="cont-input">
					<textarea class="textarea-material" name="mensaje" required></textarea>
					<span class="highlight highlight-blue"></span>
					<span class="bar bar-blue"></span>
					<label class="blue icon-paperclip label-material"> <?php echo $services['fifthinput'] ?></label>
				</div>
				<button class="btn-material blue-material" type="submit" id="form2"><span><?php echo $services['button'] ?></span></button>
			</form>
			<div class="s-icons tx-center">
				<a href="https://www.facebook.com/redlatina/"><span class="icon-facebook"></span> Facebook</a>
				<a href="https://twitter.com/redlatinastl/"><span class="icon-twitter"></span> Twitter</a>
				<a href="https://www.instagram.com/redlatinastl/"><span class="icon-instagram"></span> Instagram</a>
			</div>
		</div>
	</main>
	
	<script src="<?php echo THEME_URL ?>/js/notifications.js"></script>
	<script>
		var sendbtn = document.querySelector('#enviar');
		var contactform = document.querySelector("#contactform");
		contactform.addEventListener('submit', function(e){
			e.preventDefault();
			sendbtn.setAttribute('disabled', 'disabled');
			listefi.ajax({
				url: '?contactar',
				method: 'post',
				data: new FormData(this),
				success: function(result){
					result = JSON.parse(result);
					if( result.state == 1 ){
						raychelNotify.success("Mensaje enviado.");
						contactform.reset();
						sendbtn.removeAttribute('disabled');
					}else{
						if( result.error.length ){
							raychelNotify.warning("Todos los campos del formulario son requeridos.","center","right");
						}else{
							raychelNotify.danger("Tu mensaje no se ha podido enviar por causas desconocidas.");
						}
						sendbtn.removeAttribute('disabled');
					}
				}
			});
		});
	</script>
<?php require THEME_PATH.'/parts/footer.php' ?>
