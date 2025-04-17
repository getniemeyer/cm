<?php
 /* Include Theme Customizer */
$theme_customizer = __DIR__ . '/inc/customizer.php';
if ( is_readable( $theme_customizer ) ) {
	require_once $theme_customizer;
}

/* General Theme Settings */
if ( ! function_exists( 'clevermatch_setup_theme' ) ) {
	function clevermatch_setup_theme() {
		// Make theme available for translation: Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'clevermatch', __DIR__ . '/languages' );

		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1536;
		}

		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);
		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style-editor.css' );
		// Default attachment display settings.
		update_option( 'image_default_align', 'none' );
		update_option( 'image_default_link_type', 'none' );
		update_option( 'image_default_size', 'large' );
		// Custom CSS styles of WorPress gallery.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
	add_action( 'after_setup_theme', 'clevermatch_setup_theme' );

	// Disable Block Directory
	remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
	remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );
}


/* Fire the wp_body_open action. */
if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}


/* Clean up head section */
add_action( 'init', 'clevermatch_disable_emojis' );

function clevermatch_disable_emojis() {
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	remove_action('wp_head', 'rest_output_link_wp_head');
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js' );   
	remove_action('template_redirect', 'rest_output_link_header', 11, 0);
	remove_action('rest_api_init', 'wp_oembed_register_route');
	remove_filter('the_content', 'wpautop');
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter('emoji_svg_url', '__return_false');
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}

function disable_emojis_tinymce( $plugins ) {
 if ( is_array( $plugins ) ) {
 return array_diff( $plugins, array( 'wpemoji' ) );
 } else {
 return array();
 }
}

/* Add and remove body_class() classes */
function clevermatch_body_class($classes) {
	// Add post/page slug
	if (is_single() || is_page()) {
	$classes[] = 'd-flex flex-column h-100';
	$classes[] = basename(get_permalink());
	}

	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option('page_on_front');
	$remove_classes = array(
	'page-template-default',
	$home_id_class
	);
	$classes = array_diff($classes, $remove_classes);

	return $classes;
}
add_filter('body_class', 'clevermatch_body_class');


/* Test if a page is a blog page.*/
function is_blog() {
	global $post;
	$posttype = get_post_type( $post );

	return ( ( is_archive() || is_author() || is_category() || is_home() || is_single() || ( is_tag() && ( 'post' === $posttype ) ) ) ? true : false );
}


/* Disable comments for Media (Image-Post, Jetpack-Carousel, etc.) */
function clevermatch_filter_media_comment_status( $open, $post_id = null ) {
	$media_post = get_post( $post_id );

	if ( 'attachment' === $media_post->post_type ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'clevermatch_filter_media_comment_status', 10, 2 );


/* Display a navigation to next/previous pages when applicable */
if ( ! function_exists( 'clevermatch_content_nav' ) ) :
	function clevermatch_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
	?>
			<div id="<?php echo esc_attr( $nav_id ); ?>" class="d-flex mb-4 justify-content-between">
				<div><?php next_posts_link( '<span aria-hidden="true">&larr;</span> ' . esc_html__( 'Older posts', 'clevermatch' ) ); ?></div>
				<div><?php previous_posts_link( esc_html__( 'Newer posts', 'clevermatch' ) . ' <span aria-hidden="true">&rarr;</span>' ); ?></div>
			</div><!-- /.d-flex -->
	<?php
		else :
			echo '<div class="clearfix"></div>';
		endif;
	}

	// Add Class
	function posts_link_attributes() {
		return 'class="btn btn-secondary btn-lg"';
	}
	add_filter( 'next_posts_link_attributes', 'posts_link_attributes' );
	add_filter( 'previous_posts_link_attributes', 'posts_link_attributes' );
endif;


/* Init Widget areas in Sidebar */
function clevermatch_widgets_init() {
	// Area 1 – Sidebar
	register_sidebar(
		array(
			'name'          => 'Primary Widget Area (Sidebar)',
			'id'            => 'primary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	// Area 2 – Footer Left
	register_sidebar(
		array(
			'name'          => 'Footer Left',
			'id'            => 'secondary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	// Area 3 – Footer Center
	register_sidebar(
		array(
			'name'          => 'Footer Center',
			'id'            => 'third_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	// Area 4 – Footer Right
	register_sidebar(
		array(
			'name'          => 'Footer Right',
			'id'            => 'fourth_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'clevermatch_widgets_init' );

/* "Theme posted on" pattern. */
if ( ! function_exists( 'clevermatch_article_posted_on' ) ) {
	function clevermatch_article_posted_on() {
		printf(
			wp_kses_post( __( '<span class="sep">Veröffentlicht am </span><time class="entry-date" datetime="%3$s">%4$s</time>', 'clevermatch' ) ),
			esc_url( get_the_permalink() ),
			esc_attr( get_the_date() . ' ' ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() . ' ' )
		);
	}
}

/* Nav Menus */
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
			'main-menu'   		=> 'Primary Navigation',
			'affiliate-menu'  => 'Affiliate Navigation',
		)
	);
}

/* Custom Nav Walker: wp_bootstrap_navwalker() */
$custom_walker = __DIR__ . '/inc/wp-bootstrap-navwalker.php';
if ( is_readable( $custom_walker ) ) {
	require_once $custom_walker;
}

/* Remove Gutenberg CSS to Load it Faster Below  */
add_action( 'wp_enqueue_scripts', 'clevermatch_remove_gutenberg_block_css', 100 );
function clevermatch_remove_gutenberg_block_css() 
{wp_dequeue_style( 'wp-block-library' ); }


/* Loading CSS and JS Files  */
function clevermatch_scripts_loader() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Styles
	wp_enqueue_style( 'wpblock', 'https://www.clevermatch.com/wp-includes/css/dist/block-library/style.min.css' , array(), $theme_version, 'all' );
	wp_enqueue_style( 'bootstrap', get_theme_file_uri( 'assets/css/bootstrap.min.css' ), array(), $theme_version, 'all' );
	wp_enqueue_style( 'fontawesome', get_theme_file_uri( 'assets/css/all.min.css' ), array(), $theme_version, 'all' );
	wp_enqueue_style( 'main', get_theme_file_uri( 'assets/css/main.css' ), array(), $theme_version, 'all' );
		
	add_filter( 'style_loader_tag',  'preload_css', 10, 2 );
	function preload_css( $html, $handle ){
		$targetHandle = array('bootstrap', 'wpblock', 'fontawesome', 'main');
		if( in_array( $handle, $targetHandle ) ){
			$html = str_replace("rel='stylesheet'", "rel='stylesheet preload' as='style'", $html);  
		}
		return $html;
	}

	// Scripts	
	wp_enqueue_script( 'boostrap', get_theme_file_uri( 'assets/js/bootstrap.bundle.min.js' ), array(), $theme_version, array('in_footer' => true,	'strategy'  => 'defer',) );
	wp_enqueue_script( 'jquery', get_theme_file_uri( 'assets/js/jquery.js' ), array(), $theme_version, array('in_header' => true,	) );

	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'clevermatch_scripts_loader' );


// Conditionally Load Event, Candidates and Jobs Plugin only on Specific Pages
	function my_scripts_deregister() {
		if ( !is_page (array ('2', '489', 'kandidatenpool') ) ) {
				wp_deregister_script( 'candidates-script' );
		}
		if (!is_page(array('29', 'jobangebote')) && !is_single()) {
				wp_deregister_script( 'jobs-script' );
		}
	}
	add_action( 'wp_print_scripts', 'my_scripts_deregister', 100 );
	
	function my_styles_dequeue() {
		if ( !is_page (array ('2', '489', 'kandidatenpool') ) ) {
			wp_dequeue_style( 'candidates-style' );
			}
		if (!is_page(array('29', 'jobangebote')) && !(is_single() && has_category('berater'))) {
			wp_dequeue_style( 'jobs-style' );
			}
		if(! is_single() && ! is_page( array(2,61) ) ) { # Only load CSS on Posts but not on Pages		
			wp_dequeue_style('vsel-style'); # css.		
			}
	}
	add_action( 'wp_enqueue_scripts', 'my_styles_dequeue', 11 );



/* Return 'page-slug' for nav menu classes */
function clevermatch_nav_class( $classes, $item ) {   
	if( 'page' == $item->object ){
			 $page = get_post( $item->object_id );
			 $classes[] = $page->post_name;   
			 }   
	return $classes; } add_filter( 'nav_menu_css_class', 'clevermatch_nav_class', 10, 2 );

	
/* Return category-name in single posts */
function add_category_name($classes = '') {
	 if(is_single()) {
			$category = get_the_category();
			$classes[] = 'category-'.$category[0]->slug; 
	 }
	 return $classes;
}
add_filter('body_class','add_category_name');
	

/* Sort Category by Alphabet */
function clevermatch_sort_alphabetical_archives( $query ) {
			// Only sort main query.
			if ( ! $query->is_main_query() ) {
					return;
			}
			// Only sort category archives.
			if ( ! is_category( array ('berater', 'branche') )) {
					return;
			}
			$query->set( 'order', 'ASC' );
			$query->set( 'orderby', 'post_title' );
	}
	add_action( 'pre_get_posts', 'clevermatch_sort_alphabetical_archives' );


/* Add Custom Meta Boxes */
	
// register meta box
function meta_fields_add_meta_box(){
	add_meta_box(
		'meta_fields_meta_box', 
		__( 'CleverMatch Beiträge' ), 
		'meta_fields_build_meta_box_callback', 
		'post',
		'side',
		'default'
	 );
}
// build meta box
function meta_fields_build_meta_box_callback( $post ){
		wp_nonce_field( 'meta_fields_save_meta_box_data', 'meta_fields_meta_box_nonce' );
		$flag = get_post_meta( $post->ID, '_meta_fields_publish_flag', true );
		?>
		<div class="inside">
			<p><strong>Flagline Veröffentlichungen</strong></p>
			<p><input type="text" id="meta_fields_publish_flag" name="meta_fields_publish_flag" value="<?php echo esc_attr( $flag ); ?>" /></p>
		</div>
		<?php
}
add_action( 'add_meta_boxes', 'meta_fields_add_meta_box' );

// save metadata
function meta_fields_save_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['meta_fields_meta_box_nonce'] ) )
		return;
	if ( ! wp_verify_nonce( $_POST['meta_fields_meta_box_nonce'], 'meta_fields_save_meta_box_data' ) )
		return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;
	if ( ! isset( $_POST['meta_fields_publish_flag'] ) )
		return;

	$flag = sanitize_text_field( $_POST['meta_fields_publish_flag'] );

	update_post_meta( $post_id, '_meta_fields_publish_flag', $flag );
}
add_action( 'save_post', 'meta_fields_save_meta_box_data' );


/* Change More Link */
function modify_read_more_link() {
		return '<a class="more-link btn btn-danger" href="' . get_permalink() . '">Jetzt lesen &nbsp;<i class="fas fa-long-arrow-right"></i></a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );


/* Add Admin Pages für Categories */
add_action('admin_menu', 'my_admin_menu'); 
	function my_admin_menu() { 
		add_submenu_page('edit.php', 'Berater', 'Berater', 'manage_options', 'edit.php?category_name=berater'); 
		add_submenu_page('edit.php', 'Pressemitteilungen', 'Pressemitteilungen', 'manage_options', 'edit.php?category_name=presse'); 
		add_submenu_page('edit.php', 'HR Interviews', 'HR Interviews', 'manage_options', 'edit.php?category_name=interviews'); 
		add_submenu_page('edit.php', 'Veröffentlichungen', 'Veröffentlichungen', 'manage_options', 'edit.php?category_name=publish'); 
		add_submenu_page('edit.php', 'Referenzen', 'Referenzen', 'manage_options', 'edit.php?category_name=referenzen'); 
	}


/* Load Media Files in Admin Area */
		function load_media_files() {
				wp_enqueue_media();
		}
		add_action('admin_enqueue_scripts', 'load_media_files');
		
		// Add Category Image to Category Editor 
		function add_category_image_field($term) {
				$image_id = get_term_meta($term->term_id, 'category-image-id', true);
				?>
				<div class="form-field term-group">
						<label for="category-image-id"><?php _e('Kategorie-Bild', 'text-domain'); ?></label>
						<input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
						<div id="category-image-wrapper">
								<?php if ($image_id) : ?>
										<?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
								<?php endif; ?>
						</div>
						<p>
								<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Bild hinzufügen', 'text-domain'); ?>" />
								<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Bild entfernen', 'text-domain'); ?>" />
						</p>
				</div>
				<script type="text/javascript">
				jQuery(document).ready(function($){
						var mediaUploader;
						$('#ct_tax_media_button').click(function(e) {
								e.preventDefault();
								if (mediaUploader) {
										mediaUploader.open();
										return;
								}
								mediaUploader = wp.media.frames.file_frame = wp.media({
										title: 'Bild wählen',
										button: {
												text: 'Bild wählen'
										},
										multiple: false
								});
								mediaUploader.on('select', function() {
										var attachment = mediaUploader.state().get('selection').first().toJSON();
										$('#category-image-id').val(attachment.id);
										$('#category-image-wrapper').html('<img src="'+attachment.url+'" style="max-width:100%;height:auto;" />');
								});
								mediaUploader.open();
						});
						$('#ct_tax_media_remove').click(function() {
								$('#category-image-id').val('');
								$('#category-image-wrapper').html('');
						});
				});
				</script>
				<?php
		}
		add_action('category_add_form_fields', 'add_category_image_field', 10, 2);
		add_action('category_edit_form_fields', 'add_category_image_field', 10, 2);
		
		// Save Category Image
		function save_category_image($term_id) {
				if (isset($_POST['category-image-id'])) {
						update_term_meta($term_id, 'category-image-id', absint($_POST['category-image-id']));
				}
		}
		add_action('created_category', 'save_category_image');
		add_action('edited_category', 'save_category_image');
		
	// Use Category Image in header.php
	function get_optimized_header_image() {
			$default_image = home_url('/media/clevermatch-header-family.webp');
			$priority_categories = array('logistics', 'familienunternehmen', 'retail', 'health', 'it', 'engineering', 'automotive', 'real-estate', 'finance', 'energy', 'media', 'tourism', 'berater', 'presse', 'interviews', 'publish', 'referenzen');
	
			if (is_category('berater') || is_tax('berater')) {
					$term = get_queried_object();
					$category_image = get_term_meta($term->term_id, 'category-image-id', true);
					return $category_image ? wp_get_attachment_image_url($category_image, 'full') : home_url('/media/clevermatch-header-6.webp');
			}
	
			if (is_category() || is_archive() || is_single()) {
					$categories = is_single() ? get_the_category() : array(get_queried_object());
					
					foreach ($priority_categories as $priority_cat) {
							foreach ($categories as $category) {
									if ($category->slug === $priority_cat) {
											switch ($priority_cat) {
													case 'berater':
															if (is_single()) {
																	foreach ($categories as $cat) {
																			if ($cat->slug !== 'berater') {
																					$image = get_term_meta($cat->term_id, 'category-image-id', true);
																					if ($image) return wp_get_attachment_image_url($image, 'full');
																			}
																	}
															}
															return home_url('/media/clevermatch-header-6.webp');
													case 'interviews':
															$image = get_term_meta($category->term_id, 'category-image-id', true);
															return $image ? wp_get_attachment_image_url($image, 'full') : home_url('/media/clevermatch-header-14.webp');
													default:
															$image = get_term_meta($category->term_id, 'category-image-id', true);
															if ($image) return wp_get_attachment_image_url($image, 'full');
											}
									}
							}
					}
			}
			return get_the_post_thumbnail_url() ?: $default_image;
	}
	
	
	function get_category_specific_image($category, $slug, $default_image) {
				$category_image = get_term_meta($category->term_id, 'category-image-id', true);
				if ($category_image) {
						return wp_get_attachment_image_url($category_image, 'full');
				}
				return home_url($default_image);
		}



/* Add Bootstrap Card to Editor Blocks */
	function register_card_blocks() {
			// Registriere Block-Script
			wp_register_script(
					'custom-card-blocks',
					get_template_directory_uri() . '/assets/js/card-blocks.js',
					array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components')
			);
	
			// Registriere Block-Styles
			wp_register_style(
					'custom-card-blocks-editor',
					get_template_directory_uri() . '/assets/css/card-blocks-editor.css',
					array(),
					filemtime(get_template_directory() . '/assets/css/card-blocks-editor.css')
			);
	
			// Registriere Card Block
			register_block_type('custom/card', array(
					'editor_script' => 'custom-card-blocks',
					'editor_style' => 'custom-card-blocks-editor',
					'render_callback' => 'render_card_block',
					'supports' => array(
							'html' => true   // Erlaubt HTML-Bearbeitung
					)
			));
	}
	add_action('init', 'register_card_blocks');
	
	function render_card_block($attributes, $content) {
			$class = isset($attributes['className']) ? ' ' . $attributes['className'] : '';
			return sprintf(
					'<div class="card cm-card mb-4%s"><div class="card-body">%s</div></div>',
					$class,
					$content
			);
	}


/* Affiliate ID to External Links */
function append_afid_to_karriereportal_links($content) {
		if (empty($content) || !isset($_COOKIE['afid'])) {
				return $content;
		}

		try {
				$afid = sanitize_text_field($_COOKIE['afid']);
				$dom = new DOMDocument();
				libxml_use_internal_errors(true);
				
				// Encoding-Hack mit Nachbearbeitung
				$wrapped_content = '<?xml encoding="UTF-8"?><div id="afid-wrapper">' . $content . '</div>';
				$dom->loadHTML($wrapped_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
				
				// Entfernen des XML-PI-Nodes
				foreach ($dom->childNodes as $node) {
						if ($node->nodeType === XML_PI_NODE) {
								$dom->removeChild($node);
								break;
						}
				}
				$dom->encoding = 'UTF-8';
				
				// XPath-Verarbeitung wie ursprünglich
				$xpath = new DOMXPath($dom);
				$buttons = $xpath->query('//div[@id="afid-wrapper"]//a[contains(@class, "btn")]');
				
				if ($buttons->length > 0) {
						foreach ($buttons as $button) {
								$href = $button->getAttribute('href');
								if ($href && strpos($href, 'afid=') === false) {
										$button->setAttribute('href', add_query_arg('afid', $afid, $href));
								}
						}
				}
				
				// Content-Extraktion
				$wrapper = $xpath->query('//div[@id="afid-wrapper"]')->item(0);
				$innerHTML = '';
				if ($wrapper) {
						foreach ($wrapper->childNodes as $child) {
								$innerHTML .= $dom->saveHTML($child);
						}
				}
				
				libxml_clear_errors();
				return $innerHTML;
				
		} catch (Exception $e) {
				return $content;
		}
}
add_filter('the_content', 'append_afid_to_karriereportal_links');

/**
	 * Generate Shortcode for iFrames with Affiliate ID
	 */
	function clevermatch_iframe_shortcode($atts) {
			// Standardwerte definieren und Attribute validieren
			$atts = wp_parse_args($atts, [
					'type' => 'leadform'
			]);
	
			// Basis-URLs definieren
			$iframe_urls = [
					'leadform' => 'https://hire.clevermatch.com/frame/leadform/',
					'candidatealert' => 'https://hire.clevermatch.com/de/frame/candidatealert/'
			];
	
			// Prüfen ob der Typ gültig ist
			if (!array_key_exists($atts['type'], $iframe_urls)) {
					return '';
			}
	
			// AFID sicher aus Cookie holen
			$afid = '';
			if (isset($_COOKIE['afid'])) {
					$afid = sanitize_text_field($_COOKIE['afid']);
			}
	
			// Base URL aufbauen
			$iframe_src = $iframe_urls[$atts['type']];
	
			// AFID anhängen wenn vorhanden
			if (!empty($afid)) {
					$iframe_src = add_query_arg('afid', urlencode($afid), $iframe_src);
			}
	
			// HTML für verschiedene Typen generieren
			switch ($atts['type']) {
					case 'leadform':
							return sprintf(
									'<section class="cm--client-form mt-4">
											<style>iframe {background-color: transparent;border: 0 none transparent;padding: 0;margin: 0;}</style>
											<script>
													window.addEventListener("message", (event) => {
															if (event.data.endsWith("px")) resizeIframe(event.data);
													}, false);
													function resizeIframe(px) {
															const obj = document.querySelector("#lead-frame");
															if (obj) obj.style.height = px;
													}
											</script>
											<div class="container gx-1">
													<iframe src="%s" id="lead-frame" width="100%%" scrolling="no" onload="resizeIframe(this)"></iframe>
											</div>
									</section>',
									esc_url($iframe_src)
							);
	
					case 'candidatealert':
							return sprintf(
									'<div class="cm-alert">
											<h4 class="mb-4">Info bei neuen Kandidaten?</h4>
											<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#alertModal">
													Kandidaten-Abo einrichten
											</button>
											<div class="modal" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-lg">
															<div class="modal-content">
																	<div class="modal-header">
																			<h4 class="modal-title" id="alertModalLabel">Kandidaten-Abo einrichten</h4>
																			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																	</div>
																	<div class="modal-body">
																			<iframe class="seamless" id="alert-frame" src="%s" width="100%%" scrolling="no"></iframe>
																	</div>
															</div>
													</div>
											</div>
									</div>',
									esc_url($iframe_src)
							);
	
					default:
							return '';
			}
	}
	add_shortcode('clevermatch_iframe', 'clevermatch_iframe_shortcode');
