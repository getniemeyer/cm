<?php
/**
 * The Template for displaying all Referenzen single posts.
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
?>
        <h3>Referenz:</h3><br>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'col-sm-12 ref-post' ); ?>>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?php the_title(); ?></h3>
                    <div class="card-text entry-content">
                        <?php
                        if ( is_search() ) {
                            the_excerpt();
                        } else {
                            the_content();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </article>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    endwhile;
endif;

wp_reset_postdata();

$count_posts = wp_count_posts();

if ( $count_posts->publish > '1' ) :
    $next_post = get_next_post();
    $prev_post = get_previous_post();
?>
    <hr class="wp-block-separator has-alpha-channel-opacity is-style-wide mt-4">
    
    <div class="text-center my-5">
        <a href="<?php echo esc_url( home_url() ); ?>/clevermatch/referenzen/" class="btn btn-info">Alle Referenzen anzeigen</a>
    </div>
<?php
endif;

get_footer();
