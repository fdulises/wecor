<?php
	namespace wecor;

	require APP_SEC_DIR.'/header.php';
?>
	<div method="post" class="container cont-white cont-700">
		<h1 class=""><span class="icon-info-circle"></span> Información del sistema</h1>
		<div>
			<p><?php echo config::get('cms_name') ?> <?php echo config::get('cms_version') ?> <?php echo extras::formatoDate(config::get('cms_updated'), 'Y-m-d') ?></p>
			<p>Software creado por el equipo Debred</p>
			<p>Todos los derechos reservados</p>
			<p><a href="http://debred.com">Visitar Debred.com</a></p>
			<p>Versión actual de PHP: <?php echo phpversion(); ?></p>
		</div>

	</div>
<?php require APP_SEC_DIR.'/footer.php'; ?>
