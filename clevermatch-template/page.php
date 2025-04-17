<?php
/**
 * Template Name: Page Standard
 * Description: Page template without Sidebar.
 *
 */

get_header();

the_post();
?>
	<div class="row">
		<div class="col-sm-12">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php
				the_content();
	
				wp_link_pages(
					array(
						'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'clevermatch' ) . '">',
						'after'    => '</nav>',
						'pagelink' => esc_html__( 'Page %', 'clevermatch' ),
					)
				);
			?>
			<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			?>
		</div><!-- /.col -->
	</div><!-- /.row -->
<?php
get_footer();