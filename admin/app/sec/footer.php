<?php namespace wecor; ?>
			<footer class="container cont-700 mg-sec tx-center">
				<h6><?php echo config::get('cms_name'); ?> &copy <?php echo date('Y'); ?></h6>
			</footer>
		</div>
	</article>
	<script src="<?php echo APP_ROOT; ?>/theme/js/listefi.js"></script>
	<script src="<?php echo APP_ROOT; ?>/theme/js/helpers.js"></script>
	<script src="<?php echo APP_ROOT; ?>/theme/js/main.js"></script>
	<?php event::fire('footer_loaded'); ?>
</body>
</html>
