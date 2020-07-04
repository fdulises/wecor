<?php
	namespace wecor;

	site::setMeta( 'title', 'The leading spanish-bilingual newspaper' );
	site::setMeta( 'description', 'The leading spanish-bilingual newspaper' );
	site::setMeta( 'pagelink', config::get('site_url') );
	site::setMeta( 'cover', config::get('site_url').'/media/covers/default.jpg' );

	$yurl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCtU-SSKr-meMcGtZtR1XHcA&maxResults=50&order=date&key=AIzaSyD7405tudPLhYMrf_DreyllfETXxQM2mkM';

	//Hace peticion http y retorna headers y array de post wordpress
	function getdata($url){
		$httpreq = new HttpConnection;
		$result = $httpreq->get($url);
		$result = json_decode($result, true);
		return [
			'html' => $result,
			'headers' => $httpreq::$hdrs,
		];
	}

	//Obtenemos el contenido via http
	$reqcont = getdata($yurl);
	$ydata = $reqcont['html'];

	require THEME_PATH.'/parts/header.php';
?>
      <!---contenedor principal del sitio.-->
      <main class="cont-main" id="contMain" data-state="hide">
        <!---Estructura inicial-->
        <div class="mg-sec container">
            <div class="pd-sec">
				<div class="container">
	                <h3 class="tx-center rc-letterneon" ><?php echo $language_menu['link_chanel'] ?></h3>
					
						<div class="container d-flex">
							<?php foreach ($ydata['items'] as $p): ?>
								<div class="mg-sec gd-25 gd-m-100" id="smoove-up" data-state="show">
										<a href="https://youtu.be/<?php echo $p['id']['videoId'] ?>" >
										<img src="<?php echo $p['snippet']['thumbnails']['high']['url'] ?>" alt="">
										<h5 class="tx-center rc-letterneon"><?php echo $p['snippet']['title'] ?></h5>
										</a>
								</div>
							<?php endforeach; ?>
						</div>
					
				</div>
            </div>
        </div>
    </main>
<script src="<?php echo THEME_URL ?>/js/slide.js"></script>
<?php require THEME_PATH.'/parts/footer.php' ?>
