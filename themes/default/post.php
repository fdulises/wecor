<?php
	namespace wecor;

	$slug = routes::$params['slug'];

	$post = post::get(array(
		'columns' => [
			'p.id', 'p.title', 'p.content', 'p.slug', 'p.descrip', 'p.updated', 'p.autor', 'p.state', 'p.coverlocal'
		],
		'type' => 'post',
		'slug' => $slug
	));

	if( !$post ) extras::e404();

	if( $post['coverlocal'] ){
		$post['cover'] = config::get('site_url').'/media/covers/'.$post['coverlocal'];
	}else $post['cover'] = config::get('site_url').'/media/covers/default.jpg';

	site::setMeta( 'title', $post['title'] );
	site::setMeta( 'description', $post['descrip'] );
	site::setMeta( 'pagelink', config::get('site_url').'/'.routes::$params['slug'] );
	site::setMeta( 'cover', $post['cover'] );

	require THEME_PATH.'/parts/header.php';
?>
	<div id="" class="pd-sec bg-blue bg-animated">
		<div class="container cont-800">
			<div class="tx-center">
				<h1><?php echo $post['title'] ?></h1>
				<p><?php echo $post['descrip'] ?></p>
			</div>
		</div>
	</div>
	<div class="bg-default pd-sec">
		<div class="container cont-700">
			<p class="tx-center"><img src="<?php echo $post['cover'] ?>" alt="<?php echo $post['title'] ?>" class="cover"></p>
			<?php echo $post['content'] ?>
		</div>
	</div>
<?php require THEME_PATH.'/parts/footer.php' ?>
