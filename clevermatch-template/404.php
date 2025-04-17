<?php
/**
 * Template Name: Not found
 * Description: Page template 404 Not found.
 *
 */

get_header();

?>
<div id="post-0" class="content error404 not-found">
	<h1 class="entry-title"><?php esc_html_e( 'Sorry, diese Seite konnten wir nicht finden.', 'clevermatch' ); ?></h1>
	<div class="entry-content">
		<p><?php esc_html_e( 'Bitte wählen Sie eine andere Seite über das Menü oben aus.', 'clevermatch' ); ?></p>
	</div><!-- /.entry-content -->
</div><!-- /#post-0 -->
<?php
get_footer();
