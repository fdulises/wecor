<?php namespace wecor; ?>
<div id="infnav" class="bg-blue pd-sec">
	<div class="container">
		<ul>
			<li><a href="https://fb.com/neuralpin"><span class="icon-facebook"></span></a></li>
			<li><a href="https://twitter.com/@neuralpin"><span class="icon-twitter"></span></a></li>
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
<script src="<?php echo THEME_URL ?>/js/listefi.min.js"></script>
<script src="<?php echo THEME_URL ?>/js/highlight.pack.js"></script>
<script src="<?php echo THEME_URL ?>/js/main.js"></script>
</body>
</html>
