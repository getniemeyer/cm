<?php
/**
 * The template for displaying the berater archive loop.
 */

if ( have_posts() ) :
?>
<section class="cm--consultants overflow-hidden">
	<div class="row gy-5 gx-5">
	<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'content', 'berater' ); 
		endwhile;
	?>
	</div>
</section>
<?php
endif;

wp_reset_postdata();

clevermatch_content_nav( 'nav-below' );
