<?php
/**
 * The Template for displaying Category Archive pages.
 */

get_header();
 
 if ( have_posts() ) :
	 $category = get_queried_object();
 ?>
		 <header class="page-header pb-5">
				 <h1 class="page-title"><?php printf( esc_html__( 'Unsere Experten in der Branche: %s', 'clevermatch' ), single_cat_title( '', false ) ); ?></h1>
				 <?php
				 $category_description = category_description();
				 if ( ! empty( $category_description ) ) :
						 echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
				 endif;
				 ?>
		 </header>
 
		 <section class="cm--consultants overflow-hidden">
				 <div class="row gy-5 gx-5">
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
																 // Kategorien mit parent 5
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
																 // Kategorien mit parent 21
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
																 // Kategorien mit parent 17
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
				 <?php
				 endwhile;
				 ?>
				 </div>
		 </section>
 
		 <?php clevermatch_content_nav( 'nav-below' ); ?>
 
 <?php
 else :
		 // 404.
		 get_template_part( 'content', 'berater' );
 endif;
 
 wp_reset_postdata();
 ?>
 
 <div class="text-center my-5">
		 <a href="<?php echo esc_url( home_url() ); ?>/clevermatch/berater/" class="btn btn-info">Alle Berater anzeigen</a>
 </div>
 
 <?php
 get_footer();
