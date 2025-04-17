<?php
/**
 * The Template for displaying all single posts in category 'events'.
 */

get_header();

if ( have_posts() ) :
		while ( have_posts() ) :
				the_post();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="card cm-card">

		<header class="entry-header">
			<h1 class="entry-title mb-4"><?php the_title(); ?></h1>
			<?php if ( 'post' === get_post_type() ) : ?>
			<?php endif; ?>
		</header>

		<div class="entry-content pt-4">
			<?php
				if ( has_post_thumbnail() ) :
						echo '<div class="post-thumbnail pt-2 pb-5">' . get_the_post_thumbnail( get_the_ID(), 'medium' ) . '</div>';
				endif;

				the_content();
				?>
		</div>

	</div>

	<div class="text-center my-5">
		<a href="<?php echo esc_url( home_url() ); ?>/clevermatch/events/" class="btn btn-info">Alle Veröffentlichungen anzeigen</a>
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