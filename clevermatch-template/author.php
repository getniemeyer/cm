<?php
/**
 * The Template for displaying Author pages.
 */

get_header();

if ( have_posts() ) :	the_post(); ?>

	<header class="page-header">
		<h1 class="page-title author">
			<?php
				printf( esc_html__( 'Author Archives: %s', 'bootleg' ), get_the_author() );
			?>
		</h1>
	</header>
<?php
	get_template_part( 'author', 'bio' );

	rewind_posts();

	get_template_part( 'archive', 'loop' );
else :
	// 404.
	get_template_part( 'content', 'none' );
endif;

wp_reset_postdata(); // End of the loop.

get_footer();
