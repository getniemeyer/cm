<header class="header">

	<div class="topbar fixed-top bg-light">
		<div class="container-fluid">
			<div class="navbar-text text-end d-flex flex-row justify-content-end">
				<!-- 
				<span class="lang-select-lg">
					<a class="active" href="<?php echo esc_url( home_url() ); ?>"> DE</a> | <a href="<?php echo esc_url( home_url() ); ?>/en/">EN</a>
				</span> -->
				
				<div class="dropdown dd-login">
		
					<button type="button" class="btn-login dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fa fas fa-sign-in"><span>&nbsp;Login</span></i>
					</button>
				
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="https://hire.clevermatch.com/" target="_blank">Für Unternehmen</a></li>
						<li><a class="dropdown-item" href="https://jobs.clevermatch.com/de/job/login/" target="_blank">Für Kandidaten</a></li>
						<li><a class="dropdown-item" href="https://jobs.clevermatch.com/de/affiliate/" target="_blank">Für Empfehlungspartner</a></li>
					</ul>
				
				</div>
			</div>
		</div>
	</div>

	<nav class="navbar navbar-expand-lg fixed-top bg-light px-sm-3">

		<div class="container-fluid">
			<a class="navbar-brand" href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			<img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/assets/img/cm-logo-zukunft.svg" alt="CleverMatch Logo" width="361" height="72"></a>
			
			<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="<?php esc_attr_e( 'Toggle navigation', 'bootleg' ); ?>">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">

				<div class="offcanvas-header justify-content-end pt-3 pb-1 pe-5">
					<button type="button" class="btn-close text-reset align-end" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>

				<?php
					wp_nav_menu(
						array(
							'theme_location'  => 'main-menu',
							'container'       => '',
							'container_class' => 'offcanvas-body',
							'menu_class'      => 'navbar-nav justify-content-between flex-shrink-1',
							'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
							'walker'          => new WP_Bootstrap_Navwalker(),
						)
					);
				?>
			</div><!-- /.offcanvas -->
			<form class="cm-cta me-md-5">
				<a href="https://jobs.clevermatch.com/de/affiliate/register/" class="btn btn-warning" type="submit">Jetzt registrieren!</a>
			</form>

		</div><!-- /.container-fluid -->
	</nav><!-- /.navbar -->
</header><!-- /.header -->