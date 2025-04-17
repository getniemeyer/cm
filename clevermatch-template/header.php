<!DOCTYPE html>
<html <?php language_attributes(); ?> class="h-100">
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">
	<?php wp_head(); ?>
	<?php if (is_front_page()) { ?>
	<script>
		jQuery(document).ready(function($) {
			$('div.cm--certCand div.card:gt(2)').hide();
			var l = $('.cm--certCand div.card').length;
			if (l > 3) {
				$('span').show();
			} else {
				$('span').hide();
			}
		})
	</script>
	<?php } ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<?php get_template_part('inc/navbar-offcanvas'); ?>

	<div class="wrap gx-5">

		<?php if (is_front_page()) : ?>
		<div class="cm--stage d-flex align-items-start">
			<div class="d-inline-flex">
				<div class="cm--stage-banner container-md align-self-end align-self-md-center">
					<h1>Schneller zum.<br>perfekten Match.</h1>
					<p class="col-sm-5 col-md-10">Digital. Effizient. Zukunftsorientiert.</p>
				</div>
			</div>
		</div>

		<?php elseif (is_404()) : ?>
		<div class="cm--stage" style="background-image: url('<?php echo esc_url(home_url()); ?>/media/clevermatch-header-1.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
		</div>

		<?php else : ?>
		<div class="cm--stage" style="background-image: url('<?php echo get_optimized_header_image(); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
		</div>
		<?php endif; ?>


		<div class="main container flex-shrink-0">

			<?php if ( is_single('presse') ) : ?>
			<div class="row">
				<div class="col-sm-12">
					<?php endif; ?>