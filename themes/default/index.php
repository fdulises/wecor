<?php
	namespace wecor;

	site::setMeta( 'title', 'Desarrollo Web' );
	site::setMeta( 'description', 'Somos una agencia de desarrollo web trabajando con el objetivo de ayudar a nuestros socios a tener presencia y operatividad en internet' );
	site::setMeta( 'pagelink', config::get('site_url') );
	site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );

	require THEME_PATH.'/parts/header.php';
?>
	<div class="bg-img">
		<div id="" class="pd-sec bg-blue">
			<div class="container cont-800">
				<h1 class="tx-center">Sistema de gestión de contenidos</h1>
				<div class="tx-center">
					<h3>Stradow es un software para el desarrollo de sitios web personalizados autoadministrables.</h3>
					<a href="contacto" class="btn btn-acent size-l">Obtener Stradow</a>
				</div>
			</div>
		</div>
	</div>
	<div class="pd-sec cont-features">
		<div class="container">
			<div class="gd-50 gd-b-100">
				<h3>Complementos</h3>
				<p>Extiende el funcionamiento de tu aplicacion en pocos pasos instalando complementos que tenemos listos para tí o empieza a desarrollar uno propio.</p>
				<p><a href="#" class="btn btn-default">Proximamente</a></p>
			</div>
			<div class="gd-50 gd-b-100">
				<h3>Plantillas</h3>
				<p>Cambia completamente la apariencia y funcionalidad del sitio mediante diseños completamente optimizados para los motores de busqueda y para los usuarios.</p>
				<p><a href="#" class="btn btn-default">Proximamente</a></p>
			</div>
		</div>
	</div>
<?php require THEME_PATH.'/parts/footer.php' ?>
