			<?php if ( is_single() || is_archive() ) : ?>
					</div><!-- /.col -->

					<?php get_sidebar(); ?>

				</div><!-- /.row -->
			<?php endif; ?>
		</div><!-- /.container -->
	</div><!-- /.wrap -->
		
	
	<footer class="footer mt-auto py-4 px-3">
		<div class="container-fluid px-3">

			<div class="row py-5">
				<div class="col-sm-12 col-md-6">
					<h2 class="mb-4">Sind Sie bereit für den cleveren Match? </h2>
					<a href="/unternehmen/kandidatenpool/" class="btn btn-info mb-3" role="button">Jetzt zum Kandidatenpool <i class="fas fa-long-arrow-right"></i></a> &nbsp; &nbsp;
					<a href="/bewerber/jobangebote/" class="btn btn-info mb-3 mt-lg-0" role="button">Jetzt zu Jobangeboten <i class="fas fa-long-arrow-right"></i></a>
					<a href="https://jobs.clevermatch.com/de/affiliate/?utm_source=www&utm_campaign=footer_button" class="btn btn-warning mb-3 mt-lg-0">Zum Empfehlungsprogramm <i class="fas fa-long-arrow-right"></i></a>

				</div>
				<div class="col-sm-12 col-md-5 offset-md-1 pt-5 pt-lg-1">
					<div class="cm--social d-flex justify-content-evenly">
					<a href="https://www.xing.com/pages/clevermatch" target="_blank" rel="noopener noreferrer"><img class="social" src="<?php echo get_template_directory_uri(); ?>/assets/img/white-xing.svg" width=40 height=40 alt="CleverMatch @ Xing"></a>
					<a href="https://www.linkedin.com/company/clevermatch/" target="_blank" rel="noopener noreferrer"><img class="social" src="<?php echo get_template_directory_uri(); ?>/assets/img/white-linkedin.svg" width=40 height=40 alt="CleverMatch @ LinkedIn"></a>
					<a href="https://www.facebook.com/clevermatch%20" target="_blank" rel="noopener noreferrer"><img class="social" src="<?php echo get_template_directory_uri(); ?>/assets/img/white-facebook.svg" width=40 height=40 alt="CleverMatch @ Facebook"></a>
					<a href="https://www.instagram.com/clevermatch/" target="_blank" rel="noopener noreferrer"><img class="social" src="<?php echo get_template_directory_uri(); ?>/assets/img/white-instagram.svg" width=40 height=40 alt="CleverMatch @ Instagram"></a>
					</div>
				</div>
			</div>

			<div class="row widget-area pt-5">
				
				<div class="col-sm-12 col-md-12 col-lg-3 pb-5">
					<img class="img-fluid" src="<?php echo esc_url( home_url() ); ?>/media/logo-negativ.webp" alt="CleverMatch Logo negativ" width="326" height="59" loading="lazy">
				</div>
				
				<div class="col-6 col-md-4 col-lg-3 offset-lg-1 py-2">
					<?php dynamic_sidebar( 'secondary_widget_area' );
					if ( current_user_can( 'manage_options' ) ) : ?>
					<?php endif; ?>
				</div>
				
				<div class="col-6 col-md-4 col-lg-2 py-2">
					<?php dynamic_sidebar( 'third_widget_area' );
					if ( current_user_can( 'manage_options' ) ) : ?>
					<?php endif; ?>
				</div>
				
				<div class="col-sm-12 col-md-4 col-lg-3 py-2">
					<?php dynamic_sidebar( 'fourth_widget_area' );
					if ( current_user_can( 'manage_options' ) ) : ?>
					<?php endif; ?>
				</div>
				
				<?php
					if ( has_nav_menu( 'footer-menu' ) ) : 
						wp_nav_menu(
							array(
								'container'       => 'nav',
								'container_class' => 'col-md-6',
								//'fallback_cb'     => 'WP_Bootstrap4_Navwalker_Footer::fallback',
								'walker'          => new WP_Bootstrap4_Navwalker_Footer(),
								'theme_location'  => 'footer-menu',
								'items_wrap'      => '<ul class="menu nav justify-content-end">%3$s</ul>',
							)
						);
					endif;
				?>
			</div>
		</div><!-- /.container -->
	</footer><!-- /.footer -->
<?php wp_footer(); ?>
</body>
</html>