<?php
/**
 * Template Name: Landing Page
 * Description: Page template without Header Image and Sidebar.
 *
 */

get_header();
?>
<style>.cm--stage {display:none}</style>
<?php
	the_post();
?>
	<div class="row">
		<div class="col-sm-12">
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