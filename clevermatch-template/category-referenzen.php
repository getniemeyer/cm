<?php
/**
 * The Template for displaying Category Archive Referenzen pages.
 */

get_header();

if ( have_posts() ) :
?>
		<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Alle %s', 'clevermatch' ), single_cat_title( '', false ) ); ?></h1>
		</header>

		<section class="cm--referenzen overflow-hidden">
				<div class="row gy-5 gx-5">
				<?php
				while ( have_posts() ) :
						the_post();
				?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-sm-12 ref-post' ); ?>>
								<div class="card">
										<div class="card-body">
												<h3 class="card-title"><?php the_title(); ?></h3>
												<div class="card-text entry-content">
														<?php
														if ( is_search() ) {
																the_excerpt();
														} else {
																the_content();
														}
														?>
												</div>
										</div>
								</div>
						</article>
				<?php
				endwhile;
				?>
				</div>
		</section>

		<?php clevermatch_content_nav( 'nav-below' ); ?>
<?php
else :
		get_template_part( 'content', 'none' );
endif;

wp_reset_postdata();
get_footer();
