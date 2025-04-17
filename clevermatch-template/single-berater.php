<?php
/**
 * The Template for displaying all single posts in category 'berater'.
 */

get_header();

if ( have_posts() ) :
		while ( have_posts() ) :
				the_post();
?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header">
								<h1 class="entry-title"><?php the_title(); ?></h1>
								<?php if ( 'post' === get_post_type() ) : ?>
								<?php endif; ?>
						</header>

						<div class="entry-content">
								<?php the_content(); ?>
						</div>

						<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide mt-4">

						<div class="text-center my-5">
								<a href="<?php echo esc_url( home_url() ); ?>/clevermatch/berater/" class="btn btn-info">Alle Berater anzeigen</a>
						</div>
				</article>
<?php
		endwhile;
endif;

wp_reset_postdata();

$count_posts = wp_count_posts();

if ( $count_posts->publish > '1' ) :
		$next_post = get_next_post();
		$prev_post = get_previous_post();
endif;

get_footer();
