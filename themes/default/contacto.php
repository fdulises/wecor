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
	<div id="" class="pd-sec bg-blue">
		<div class="container cont-600">
			<div class="tx-center">
				<h1 class="tx-center">Queremos saber acerca de tu proyecto</h1>
				<p>Para mandarnos un mensaje completa el formulario de contacto o escríbenos directamente a nuestro e-mail contacto[arroba]debred.com, te responderemos en breve.</p>
			</div>
		</div>
	</div>
	<div class="pd-sec">
		<form id="contactform" class="container cont-600 mg-sec" method="post" action="?contactar">
			<h2 class="tx-center">Escribenos un mensaje</h2>
			<div class="form-sec">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" class="form-in" />
				<span class="icon icon-user form-decoration"></span>
			</div>
			<div class="form-sec">
				<label for="email">Correo</label>
				<input type="email" name="email" id="email" class="form-in" />
				<span class="icon icon-envelope-o form-decoration"></span>
			</div>
			<div class="form-sec">
				<label for="asunto">Asunto</label>
				<input type="asunto" name="asunto" id="asunto" class="form-in" />
				<span class="icon icon-font form-decoration"></span>
			</div>
			<div class="form-sec">
				<label for="telefono">Telefono</label>
				<input type="text" name="telefono" id="telefono" class="form-in" />
				<span class="icon icon-whatsapp form-decoration"></span>
			</div>
			<div class="form-sec">
				<label for="mensaje">Mensaje</label>
				<textarea rows="5" name="mensaje" id="mensaje" class="form-in"></textarea>
			</div>
			<div class="form-sec">
				<button id="enviar" class="btn btn-acent btn-block size-l" type="submit">Enviar mensaje</button>
			</div>
		</form>
	</div>
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
						listefi.alert('<p>Gracias por ponerte en contacto con nosotros.</p><p>Te responderemos en breve.</p>', 'Mensaje enviado');
						contactform.reset();
						sendbtn.removeAttribute('disabled');
					}else{
						if( result.error.length ){
							listefi.alert('<p>Tu mensaje no se ha podido enviar.</p><p>Todos los campos del formulario son requeridos.</p>', 'Faltan campos');
						}else{
							listefi.alert('<p>Tu mensaje no se ha podido enviar por causas desconocidas.</p><p>Disculpa las molestias y por favor vuelve a intentar más tarde.</p>', 'Ocurrió un Error');
						}
						sendbtn.removeAttribute('disabled');
					}
				}
			});
		});
	</script>
<?php require THEME_PATH.'/parts/footer.php' ?>
