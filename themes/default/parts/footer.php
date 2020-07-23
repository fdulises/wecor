<?php namespace wecor; ?>
<div id="infnav" class="bg-blue pd-sec">
	<div class="container">
		<ul>
			<li><a href="inicio">Inicio</a></li>
			<li><a href="acercade">Acerca de</a></li>
			<li><a href="contacto">Contacto</a></li>
		</ul>
	</div>
</div>
<footer id="footer" class="pd-sec">
	<div class="container">
		<div class="tx-center">
			<?php echo config::get('site_title') ?> &copy; <?php echo date('Y') ?> <span class="hide-s">- Todos los derechos reservados</span>
		</div>
	</div>
</footer>
<script src="<?php echo THEME_URL ?>/js/listefi.js"></script>
<script src="<?php echo THEME_URL ?>/js/highlight.pack.js"></script>
<script src="<?php echo THEME_URL ?>/js/main.js"></script>
</body>
</html>
