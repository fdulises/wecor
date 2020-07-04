<?php namespace wecor; ?>
<div id="infnav" class="bg-blue pd-sec">
	<div class="container">
		<ul>
			<li><a href="inicio">Inicio</a></li>
			<li><a href="code">Documentación</a></li>
			<li><a href="acercade">Acerca de</a></li>
			<li><a href="contacto">Contacto</a></li>
		</ul>
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
<script src="<?php echo THEME_URL ?>/js/highlight.pack.js"></script>
<script src="<?php echo THEME_URL ?>/js/holder.min.js"></script>
<script src="<?php echo THEME_URL ?>/js/main.js"></script>
</body>
</html>
