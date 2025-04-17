<?php
/**
 * The Template for displaying Category Archive Pressemitteilungen (presse).
 */

get_header();

if ( have_posts() ) :
?>
<header class="page-header pb-5 pt-4">
	<h1 class="page-title">Die aktuellen CleverMatch Pressemitteilungen.</h1>
</header>
<section class="cm--presse">
	<div class="row gy-5 gx-5">
		<?php
				while ( have_posts() ) :
						the_post();
				?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-sm-12' ); ?>>
			<a href="<?php the_permalink(); ?>">
				<div class="card cm-card">
					<div class="entry-meta">
						<?php clevermatch_article_posted_on(); ?>
					</div>
					<header>
						<h4 class="wp-block-heading">
							<?php the_title(); ?>
						</h4>
					</header>
					<div class="entry-content">
						<?php echo wp_trim_words(get_the_excerpt(), 20); ?>
					</div>
				</div>
			</a>
		</article>
		<?php
				endwhile;
				?>
	</div>
</section>
<?php
else :
		get_template_part( 'content', 'none' );
endif;

wp_reset_postdata();
get_footer();