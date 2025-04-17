<?php
/**
 * The Template used to display Tag Archive pages.
 */

get_header();

if ( have_posts() ) :
?>
<div class="main container flex-shrink-0">
	<div class="row">
		<div class="col-sm-12">
			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Tag: %s', 'clevermatch' ), single_tag_title( '', false ) ); ?></h1>
				<?php
					$tag_description = tag_description();
					if ( ! empty( $tag_description ) ) :
						echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
					endif;
				?>
			</header>
		<?php
			get_template_part( 'archive', 'loop' );
		else :
			// 404.
			get_template_part( 'content', 'none' );
		endif;
		
		wp_reset_postdata(); // End of the loop.
		
		?>
		</div><!-- /.col -->
	</div><!-- /.row -->
<?php
get_footer();