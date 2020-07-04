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
				<h1 class="tx-center">Acerca de nosotros</h1>
				<p>Debred es una empresa de desarrollo web que fue fundada por jóvenes mexicanos en el año 2014 y que tiene como objetivo ayudar a otras empresas a tener presencia y operatividad en internet.</p>
			</div>
		</div>
	</div>
	<div class="bg-default pd-sec">
		<div class="container cont-600">

			<p>En Debred nos especializamos en desarrollar sitios y tiendas en línea, con diseños optimizados, funcionales y con un diseño estético atractivo, además ofrecemos el servicio de desarrollo de campañas publicitarias en línea que tienen como objetivo aumentar la visibilidad de nuestros clientes y a su vez mejorar sus ventas.
			</p>

			<p>Nuestro sitio web tiene incluido un blog en el que publicamos artículos periódicamente para poder informar a nuestros clientes, lectores y visitantes ocasionales, sobre nuestras actividades y sobre temas acerca de nuestra materia de trabajo en general,  con esto pretendemos despejar las dudas que pueden haber sobre el desarrollo web y servir como una fuente confiable para aquellos que quieran aprender más sobre el amplio mundo del internet.
			</p>

			<h2 class="tx-center">Nuestra misión</h2>

			<p>La misión de Debred es brindar apoyo por medio del internet a pequeñas y medianas empresas, con el propósito de acelerar su crecimiento y desarrollo y de mejorar su imagen ante su público.
			</p>

			<h2 class="tx-center">Nuestra Visión</h2>

			<p>Nuestra visión a 5 años es llegar a ser una empresa líder en el ramo del desarrollo web, con alta presencia en el mercado nacional, con una calidad de servicio pulcra e intachable y con un portafolio de trabajos de más de 2000 proyectos.</p>

			<p>En Debred trabajamos para ayudar a las empresas a abrirse camino en la red y para aumentar su visibilidad en un mercado cada vez más amplio y globalizado.
			</p>
		</div>
	</div>
	<?php /*
	<div class="pd-sec" id="">
		<div class="container">
			<h2 class="tx-center">Sección Principal #2</h2>
			<div class="container">
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#">
						<img src="holder.js/300x200?random=yes&auto=yes" class="cover">
						<h4 class="card-title tx-center">Lorem ipsum dolor</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#">
						<img src="holder.js/300x200?random=yes&auto=yes" class="cover">
						<h4 class="card-title tx-center">Lorem ipsum dolor</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#">
						<img src="holder.js/300x200?random=yes&auto=yes" class="cover">
						<h4 class="card-title tx-center">Lorem ipsum dolor</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#">
						<img src="holder.js/300x200?random=yes&auto=yes" class="cover">
						<h4 class="card-title tx-center">Lorem ipsum dolor</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#">
						<img src="holder.js/300x200?random=yes&auto=yes" class="cover">
						<h4 class="card-title tx-center">Lorem ipsum dolor</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#">
						<img src="holder.js/300x200?random=yes&auto=yes" class="cover">
						<h4 class="card-title tx-center">Lorem ipsum dolor</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#">
						<img src="holder.js/300x200?random=yes&auto=yes" class="cover">
						<h4 class="card-title tx-center">Lorem ipsum dolor</h4>
					</a>
				</div>
				<div class="gd-25 gd-b-50 gd-s-100">
					<a href="#">
						<img src="holder.js/300x200?random=yes&auto=yes" class="cover">
						<h4 class="card-title tx-center">Lorem ipsum dolor</h4>
					</a>
				</div>
			</div>
		</div>
	</div>
	*/ ?>
<?php require THEME_PATH.'/parts/footer.php' ?>
