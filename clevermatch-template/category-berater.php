<?php
/**
 * The Template for displaying Category Archive Berater pages.
 */
get_header();

if ( have_posts() ) :
?>
<header class="page-header">
	<h1 class="page-title">Unsere Experten, die Vakanzen erfolgreich und langfristig besetzen.<br>Und Kandidaten hilfreich zur Seite stehen.</h1>
</header>
<div class="card cm-card">
	<div class="card-body">
		<p>Unsere Berater sind Branchenexperten mit langjähriger fundierter Berufs- und Führungserfahrung. Sie begleiten Unternehmen und Kandidaten persönlich und vertrauensvoll während des gesamten Prozesses. Und sorgen dafür, dass sie schnell den passenden Kandidaten oder die passende Position finden.</p>
	</div>
</div>

<section class="cm--consultants overflow-hidden mt-5">
	<div class="row gy-4 gx-4">
		<?php
				while ( have_posts() ) :
						the_post();
				?>
		<div class="col-sm-6 col-md-4 col-lg-3">
			<article id="post-<?php the_ID(); ?>">
				<div class="card mb-4">
					<?php
						if ( has_post_thumbnail() ) { 
								the_post_thumbnail( 'full', array( 'class' => 'card-img-top img-fluid' ) );
						} 
						?>
					<div class="card-body">
						<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'clevermatch' ), the_title_attribute( array( 'echo' => false ) ) ); ?>" rel="bookmark">
							<h5 class="card-title"><?php the_title(); ?></h5>
						</a>
						<h6 class="card-subtitle text-body-secondary">
							<?php 
								// Kategorien mit parent 11
								$categories = wp_get_object_terms( $post->ID, 'category', [ 'parent' => 5, 'number' => 3 ] );
								if ( ! empty( $categories ) ) {
										$category_links = [];
										foreach ( $categories as $category ) {
												$category_links[] = ' ' . $category->name . '</a>';
										}
										echo implode( ', ', $category_links );
								}
								?><br>
							<?php 
								// Kategorien mit parent 18
								$categories = wp_get_object_terms( $post->ID, 'category', [ 'parent' => 21, 'number' => 1 ] );
								if ( ! empty( $categories ) ) {
										$category_links = [];
										foreach ( $categories as $category ) {
												$category_links[] = ' ' . $category->name . '</a>';
										}
										echo implode( ', ', $category_links );
								}
								?><br>
							<?php 
								// Kategorien mit parent 14
								$categories = wp_get_object_terms( $post->ID, 'category', [ 'parent' => 17, 'number' => 1 ] );
								if ( ! empty( $categories ) ) {
										$category_links = [];
										foreach ( $categories as $category ) {
												$category_links[] = ' ' . $category->name . '</a>';
										}
										echo implode( ', ', $category_links );
								}
								?><br>
						</h6>
						<a class="btn btn-sm btn-info" href="<?php the_permalink(); ?>" class="card-link">Zum Profil <i class="fas fa-long-arrow-right"></i></a>
					</div>
				</div>
			</article>
		</div>
		<?php endwhile; ?>
	</div>
</section>

<?php clevermatch_content_nav( 'nav-below' ); ?>
<?php
else :
		get_template_part( 'content', 'none' );
endif;

wp_reset_postdata();
get_footer();