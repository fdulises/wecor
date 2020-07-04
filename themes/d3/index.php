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
				<h1 class="tx-center">Desarrollemos tu proyecto web</h1>
				<div class="tx-center">
					<h3>Somos una agencia de desarrollo web trabajando con el objetivo de ayudar a nuestros socios a tener presencia y operatividad en internet.</h3>
					<a href="contacto" class="btn btn-acent size-l">Comenzar con mi proyecto</a>
				</div>
			</div>
		</div>
	</div>
	<?php /*
	<div class="pd-sec" id="cont-service">
		<div class="container">
			<h2 class="tx-center">Nuestros Servicios</h2>
			<div class="container tx-center">
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#design">
						<span class="icon-paint-brush"></span>
						<h4 class="card-title tx-center">Diseño Web</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#program">
						<span class="icon-gears"></span>
						<h4 class="card-title tx-center">Programación Web</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#adwords">
						<span class="icon-search"></span>
						<h4 class="card-title tx-center">Publicidad en buscadores</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#ecommerce">
						<span class="icon-shopping-basket"></span>
						<h4 class="card-title tx-center">Tiendas en línea</h4>
					</a>
				</div>
			</div>
		</div>
	</div>
	*/ ?>
	<div id="design" class="pd-sec cont-features">
		<div class="container tx-center">
			<div class="gd-50 gd-b-100">
				<img src="<?php echo THEME_URL ?>/img/muestra1.png" class="cover">
			</div>
			<div class="gd-50 gd-b-100">
				<h3>Diseño y rediseño de sitios</h3>
				<p>Muéstrale al mundo tu contenido con la mejor presentación.</p>
				<p>El diseño más que un arte es una ciencia que tiene como objetivo conectarte con tus clientes, sirviendo como puente entre tu audiencia y lo que puedes ofrecerle.</p>
				<p>Nuestro trabajo es darle una presentación a tu producto o servicio mediante una interfaz gráfica simple y clara que permita a tu visitante encontrar lo que busca.</p>
			</div>
		</div>
	</div>
	<div id="program" class="pd-sec cont-features">
		<div class="container tx-center">
			<div class="gd-50 gd-b-100 bx-right">
				<img src="<?php echo THEME_URL ?>/img/muestra2.jpg" class="cover">
			</div>
			<div class="gd-50 gd-b-100">
				<h3>Programación de software web</h3>
				<p>Si te lo puedes imaginar nosotros lo podemos desarrollar, desde pequeños programas hasta el software más complejo y elaborado.</p>
				<p>La web nos da la ventaja de crear aplicaciones que funcionen en todo tipo de dispositivos con acceso a internet.</p>
			</div>
		</div>
	</div>
	<div id="adwords" class="pd-sec cont-features">
		<div class="container tx-center">
			<div class="gd-50 gd-b-100">
				<img src="<?php echo THEME_URL ?>/img/muestra3.jpg" class="cover">
			</div>
			<div class="gd-50 gd-b-100">
				<h3>Publicidad en buscadores</h3>
				<p>Coloca tu producto o servicio en la primera página de Google.</p>
				<p>Atrae más visitantes a tu sitio web, recibe llamadas y correos desde el primer día.</p>
				<p>Con la plataforma de publicidad de Google te conectamos con los clientes que buscan lo que tú ofreces.</p>
			</div>
		</div>
	</div>
	<div id="ecommerce" class="pd-sec cont-features">
		<div class="container tx-center">
			<div class="gd-50 gd-b-100 bx-right">
				<img src="<?php echo THEME_URL ?>/img/muestra4.jpg" class="cover">
			</div>
			<div class="gd-50 gd-b-100">
				<h3>Tiendas en línea</h3>
				<p>Vende tu producto o servicio desde tu local en línea 24/7, puedes comenzar ofreciendo un solo artículo.</p>
				<p>Recibe pagos con tarjetas de crédito y débito vía PayPal.</p>
				<p>Gestiona tus ventas, promociones y métodos de envió.</p>
				<p>Tus clientes podrán visualizar tu tienda desde cualquier dispositivo.</p>
			</div>
		</div>
	</div>
<?php require THEME_PATH.'/parts/footer.php' ?>
