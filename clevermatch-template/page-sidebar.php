<?php
/**
 * Template Name: Page with Sidebar
 * Description: Page template with sidebar.
 *
 */

get_header();
	
the_post();
?>
	<div class="row">
		<div class="col-md-8 order-md-2 col-sm-12">
	 	<h1 class="entry-title"><?php the_title(); ?></h1>
	 	<?php
			the_content();
 	
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'bootleg' ),
					'after'  => '</div>',
				)
			);
			edit_post_link( esc_html__( 'Edit', 'bootleg' ), '<span class="edit-link">', '</span>' );
	 	?>
	 	<?php
	 	// If comments are open or we have at least one comment, load up the comment template.
	 	if ( comments_open() || get_comments_number() ) :
			comments_template();
	 	endif;
	 	?>
		</div><!-- /.col -->
		<?php
			get_sidebar();
		?>
	</div><!-- /.row -->
<?php
get_footer();
