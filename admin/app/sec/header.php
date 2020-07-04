<?php namespace wecor; ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8" />
	<title><?php echo config::get('cms_name') ?> - Backoffice</title>
	<link rel="stylesheet" href="<?php echo APP_ROOT; ?>/theme/css/listefi-fuentes.css" />
	<link rel="stylesheet" href="<?php echo APP_ROOT; ?>/theme/css/listefi.css" />
	<link rel="stylesheet" href="<?php echo APP_ROOT; ?>/theme/css/style.css" />
	<link rel="icon" href="<?php echo APP_ROOT; ?>/theme/img/favicon.ico" />
	<script>
	var SITIO_SEC = "<?php echo basename($controller, ".sec.php") ?>";
	var APP_ROOT = "<?php echo APP_ROOT ?>";
	</script>
	<?php event::fire('header_loaded'); ?>
</head>
<body>
	<header class="nav-bar nav-primary">
		<div class="nav-brand"><a href="<?php echo APP_ROOT; ?>"><?php echo config::get('cms_name'); ?></a></div>
		<button data-estado="open" type="button" class="btn-sadw" id="actionNav">
			<span class="icon-bars"></span>
		</button>
		<ul class="bx-right hide-m">
			<?php foreach ($usermenu->getLinkList() as $link): ?>
			<li<?php echo isset($link->meta['id']) ? ' id="'.$link->meta['id'].'"' : '' ?> class="bx-right<?php echo isset($link->meta['class']) ? ' '.$link->meta['class'] : '' ?>">
				<a href="<?php echo $link->url ?>" title="<?php echo $link->title ?>"><?php echo $link->icon ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</header>
	<article>
		<aside class="nav-abs" id="leftNav">
			<ul>
				<?php foreach ($mainmenu->getLinkList() as $link): $childlinklist = $link->getLinkList(); ?>
				<li<?php echo isset($link->meta['id']) ? ' id="'.$link->meta['id'].'"' : '' ?> class="<?php echo isset($link->meta['class']) ? ' '.$link->meta['class'] : '' ?>" data-id="<?php echo $link->id ?>">
                    <?php if( $childlinklist ): ?>
					<button class="dropener" type="button"><span class="icon-chevron-down"></span></button>
                    <?php endif; ?>
					<a href="<?php echo $link->url ?>" title="<?php echo $link->title ?>"><?php echo $link->icon ?><?php echo $link->title ?></a>
					<?php if( $childlinklist ): ?>
					<ul class="drcont">
						<?php foreach ($childlinklist as $clink): ?>
							<li<?php echo isset($clink->meta['id']) ? ' id="'.$clink->meta['id'].'"' : '' ?> class="<?php echo isset($clink->meta['class']) ? ' '.$clink->meta['class'] : '' ?>">
								<a href="<?php echo $clink->url ?>" title="<?php echo $clink->title ?>"><?php echo $clink->title ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		</aside>
		<div class="container-r clearfix" id="cont">
