<?php
	namespace wecor;

	if( file_exists(THEME_PATH.'/page.php') ): require_once THEME_PATH.'/page.php';
	else:

	routes::$params['link'] = config::get('site_url').'/'.routes::$params['slug'];
	routes::$params['cover'] = post::getPostCover(routes::$params);

	site::setMeta( 'title', routes::$params['title'] );
	site::setMeta( 'description', routes::$params['descrip'] );
	site::setMeta( 'pagelink', routes::$params['link'] );
	site::setMeta( 'cover', routes::$params['cover'] );

	require THEME_PATH.'/parts/header.php';
?>
<div class="pd-sec">
	<div class="container cont-800">
		<h1 class="tx-center"><?php echo routes::$params['title'] ?></h1>
		<?php echo routes::$params['content'] ?>
	</div>
</div>
<?php
	require THEME_PATH.'/parts/footer.php';
	endif;
?>
