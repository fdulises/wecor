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
	<div class="bg-default pd-sec">
		<div class="container cont-700">
			<div id="disqus_thread"></div>
			<script>
			var disqus_config = function () {
			this.page.url = '<?php echo site::getMeta('pagelink') ?>';
			this.page.identifier = '<?php echo $post['slug'] ?>';
			};
			(function() { // DON'T EDIT BELOW THIS LINE
			var d = document, s = d.createElement('script');
			s.src = 'https://neuralpin.disqus.com/embed.js';
			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
			})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
		</div>
	</div>
<?php require THEME_PATH.'/parts/footer.php' ?>
