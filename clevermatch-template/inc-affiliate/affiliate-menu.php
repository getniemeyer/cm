<?php
wp_nav_menu(array(
		'theme_location' => 'affiliate-menu',
		'menu_class' => 'nav nav-pills',
		'walker' => new WP_Bootstrap_Navwalker(),
));
?>
