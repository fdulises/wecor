<?php
	namespace wecor;

	$entrada = post::get([
		'columns' => [
			'p.id', 'p.title', 'p.slug', 'p.descrip', 'p.updated', 'p.cover', 'p.coverlocal', 'p.content'
		],
		'type' => 'post',
		'slug' => routes::$params[1],
	]);

	if( !$entrada ) extras::e404();

	$entrada['link'] = config::get('site_url').'/'.$entrada['slug'];
	$entrada['cover'] = post::getPostCover($entrada);

	site::setMeta( 'title', $entrada['title'] );
	site::setMeta( 'description', $entrada['descrip'] );
	site::setMeta( 'pagelink', $entrada['link'] );
	site::setMeta( 'cover', $entrada['cover'] );

	require THEME_PATH.'/parts/header.php';
?>
	<div id="" class="pd-sec bg-blue">
		<div class="container">
			<div class="tx-center">
				<h1 class="tx-center"><?php echo $entrada['title'] ?></h1>
				<?php echo $entrada['descrip'] ?>
			</div>
		</div>
	</div>
	<div class="bg-default pd-sec">
		<div class="container cont-800">
			<p class="tx-center"><img src="<?php echo $entrada['cover'] ?>" class="cover"></p>
			<?php echo $entrada['content'] ?>
		</div>
	</div>
	<?php /*
	<div class="pd-sec">
		<div class="container cont-800">
			<div class="gd-40">
				<img src="holder.js/300x200?random=yes" alt="" title="">
			</div>
			<div class="gd-60">
				<h3>NOMBRE KAWAII</h3>
				<p>Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus.</p>
			</div>
		</div>
	</div>
	*/ ?>
<?php require THEME_PATH.'/parts/footer.php' ?>
