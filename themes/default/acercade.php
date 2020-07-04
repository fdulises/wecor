<?php
	namespace wecor;

	site::setMeta( 'title', 'Acerca de nosotros' );
	site::setMeta( 'description', 'Debred es una empresa de desarrollo web que fue fundada por jóvenes mexicanos en el año 2014 y que tiene como objetivo ayudar a otras empresas a tener presencia y operatividad en internet' );
	site::setMeta( 'pagelink', config::get('site_url').'/nosotros' );
	site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );

	require THEME_PATH.'/parts/header.php';
?>
	<div id="" class="pd-sec bg-blue">
		<div class="container cont-600">
			<div class="tx-center">
				<h1 class="tx-center">Acerca de Stradow</h1>
			</div>
		</div>
	</div>
	<div class="bg-default pd-sec">
		<div class="container cont-600">

			<p>Stradow es un CMS creado y desarrollado por el equipo Debred.</p>
			<p>Con nuestro software se pueden crear sitios informativos, blogs, tiendas en linea, aplicaciones personalizadas, etc.</p>
			<h4>Algunas caracteristicas de Stradow</h4>
			<ul>
				<li>Plantillas personalizables</li>
				<li>Extendible mediante complementos</li>
				<li>Amigable con el SEO</li>
				<li>Enfocado en el rendimiento</li>
				<li>Protección de los datos del usuario e información critica del sitio</li>
				<li>Sistema de administración de archivos multimedia</li>
				<li>Sistema multiusuario con diferentes roles y niveles de acceso</li>
			</ul>

		</div>
	</div>
<?php require THEME_PATH.'/parts/footer.php' ?>
