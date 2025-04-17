<?php
/**
 * The Template for displaying Category Archive Veranstaltungen (events).
 */

get_header();

if ( have_posts() ) :
?>
		<header class="page-header pb-5 pt-4">
				<h1 class="page-title">Einblicke, Ausblicke und Ansichten.<br>Direkt von unseren Experten.</h1>
				<p>Auf den folgenden Veranstaltungen sind oder waren wir präsent.</p>
		</header>

		<section class="cm--events overflow-hidden">
				<div class="row gy-4 gx-4">
				<?php
				while ( have_posts() ) :
						the_post();
				?>
						<div class="col-sm-12 col-md-6 col-lg-4">
								<article id="post-<?php the_ID(); ?>">
										<div class="card mb-4">
												<div class="card-body">
														<p class="card-subtitle"><?php echo get_post_meta($post->ID, '_meta_fields_event_date', true); ?></p>
														
														<h5 class="card-title"><?php the_title(); ?></h5>
														
														<div class="card-text entry-content">
																<?php the_excerpt(); ?>
														</div>
												</div>
										</div>
								</article>
						</div>
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
