<?php
/**
 * The Template for displaying Category Archive Interviews.
 */

get_header();

if ( have_posts() ) :
?>
		<header class="page-header pb-5 pt-4">
				<h1 class="page-title">Cleverer denken, zukunftsweisender arbeiten.<br>Die CleverMatch Interviewreihe.</h1>
				<p>Informieren Sie sich über die neuesten Trends und wichtigen Erkenntnisse im Bereich der Personalberatung.</p>
		</header>

		<section class="cm--interviews">
				<div class="row gy-4 gx-4">
				<?php
				while ( have_posts() ) :
						the_post();
				?>
						<div class="col-sm-12 col-md-6 col-lg-4">
								<article id="post-<?php the_ID(); ?>" class="h-100">
										<div class="card h-100">
												<?php
												if ( has_post_thumbnail() ) { 
														the_post_thumbnail( 'medium', array( 'class' => 'card-img-top img-fluid' ) );
												} 
												?>
												<div class="card-body">
														<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'clevermatch' ), the_title_attribute( array( 'echo' => false ) ) ); ?>" rel="bookmark">
																<h5 class="card-title"><?php the_title(); ?></h5>
														</a>
														
														<div class="card-text entry-content">
																<?php the_excerpt(); ?>
														</div>
														
												</div>
												<div class="card-footer">
														<a class="btn btn-info btn-sm mb-2 float-end" href="<?php the_permalink(); ?>" class="card-link">Zum Interview <i class="fas fa-long-arrow-right"></i></a>
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
