<?php
	namespace wecor;

	$slug = routes::$params['slug'];

	$post = post::get(array(
		'columns' => [
			'p.id', 'p.title', 'p.content', 'p.slug', 'p.descrip', 'p.updated', 'p.autor', 'p.state'
		],
		'type' => 'post',
		'slug' => $slug
	));

	if( !$post ) extras::e404();

	site::setMeta( 'title', $post['title'] );
	site::setMeta( 'description', $post['descrip'] );
	site::setMeta( 'pagelink', config::get('site_url').'/'.routes::$params['slug'] );

	require THEME_PATH.'/parts/header.php';
?>
	<div id="" class="pd-sec bg-blue">
		<div class="container">
			<div class="tx-center">
				<h1><?php echo $post['title'] ?></h1>
				<p><?php echo $post['descrip'] ?></p>
			</div>
		</div>
	</div>
	<div class="bg-default pd-sec">
		<div class="container cont-800">
			<!--<p><img src="holder.js/800x680?random=yes&auto=yes" class="cover"></p>-->

			<?php echo $post['content'] ?>
		</div>
	</div>
	<!--<div class="pd-sec">
		<div class="container cont-800">
			<div class="gd-40">
				<img src="holder.js/300x200?random=yes" alt="" title="">
			</div>
			<div class="gd-60">
				<h3>NOMBRE KAWAII</h3>
				<p>Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin urna dolor sagittis lacus.</p>
			</div>
		</div>
	</div>-->
<?php require THEME_PATH.'/parts/footer.php' ?>
