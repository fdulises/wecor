<?php namespace wecor; ?>
<div class="bg-blue pd-sec bg-debred">
	<div class="container">
		<div class="gd-33 gd-m-50 gd-s-100">
			<h5>Navegación</h5>
			<ul>
				<li><a href="inicio">Página de inicio</a></li>
				<li><a href="nosotros">Acerca de nosotros</a></li>
			</ul>
		</div>
		<div class="gd-33 gd-m-50 hide-s">
			<h5>Qué podemos hacer</h5>
			<ul>
				<li><a href="<?php echo config::get('site_url') ?>/#design">Diseño y rediseño Web</a></li>
				<li><a href="<?php echo config::get('site_url') ?>/#program">Programación de software web</a></li>
				<li><a href="<?php echo config::get('site_url') ?>/#adwords">Publicidad en buscadores</a></li>
				<li><a href="<?php echo config::get('site_url') ?>/#ecommerce">Tiendas en linea</a></li>
			</ul>
		</div>
		<div class="gd-33 gd-m-50 gd-s-100">
			<h5>Contactanos</h5>
			<ul>
				<li><span class="icon-whatsapp"></span> 55 2179 7348</li>
				<li>Correo: contacto[arroba]debred.com</li>
				<li><a href="contacto">Formulario de contacto</a></li>
			</ul>
		</div>
	</div>
</div>
<footer id="footer" class="pd-sec">
	<div class="container">
		<div class="bx-left">
			<?php echo config::get('title') ?> &copy; <?php echo date('Y') ?> <span class="hide-s">- Todos los derechos reservados</span>
		</div>
		<div class="bx-right s-icons hide-m">
			<a href="https://fb.com/debredweb"><span class="icon-facebook"></span></a>
			<a href="https://twitter.com/@debredweb"><span class="icon-twitter"></span></a>
			<a href="https://plus.google.com/u/0/+Debredweb"><span class="icon-google-plus"></span></a>
		</div>
	</div>
</footer>
<script src="<?php echo THEME_URL ?>/js/listefi.js"></script>
<script src="<?php echo THEME_URL ?>/js/holder.min.js"></script>
<script src="<?php echo THEME_URL ?>/js/main.js"></script>
</body>
</html>
