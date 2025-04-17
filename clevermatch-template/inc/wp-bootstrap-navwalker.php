<?php
/**
 * WP Bootstrap Navwalker (customized)
 */

if ( ! class_exists( 'WP_Bootstrap_Navwalker' ) ) {
	/**
	 * WP_Bootstrap_Navwalker class.
	 * @extends Walker_Nav_Menu
	 */
	class WP_Bootstrap_Navwalker extends Walker_Nav_Menu {
		/**
		 * Start Level.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			$output .= '<ul class="dropdown-menu">';
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			/**
			 * Dividers, Headers or Disabled
			 * =============================
			 * Determine whether the item is a Divider, Header, Disabled or regular
			 * menu item. To prevent errors we use the strcasecmp() function to so a
			 * comparison that is not case sensitive. The strcasecmp() function returns
			 * a 0 if the strings are equal.
			 */
			if ( 0 === strcasecmp( $item->attr_title, 'divider' ) && 1 === $depth ) {
				$output .= '<li class="divider">';
			} elseif ( 0 === strcasecmp( $item->title, 'divider' ) && 1 === $depth ) {
				$output .= '<li class="divider">';
			} elseif ( 0 === strcasecmp( $item->attr_title, 'dropdown-header' ) && 1 === $depth ) {
				$output .= '<li class="dropdown-header">' . esc_attr( $item->title );
			} elseif ( 0 === strcasecmp( $item->attr_title, 'disabled' ) ) {
				$output .= '<li class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
			} else {
				$atts    = array();

				$classes     = empty( $item->classes ) ? array() : (array) $item->classes;
				if ( 0 === $depth ) {
					$classes[] = 'nav-item'; // First level.
				}
				$classes[]   = 'menu-item-' . $item->ID;
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
				if ( $args->has_children ) {
					$class_names .= ' dropdown';
				}
				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

				$output     .= '<li' . $class_names . '>';


				$atts['target'] = ! empty( $item->target ) ? $item->target : '';
				$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
				// If item has_children add atts to a.
				if ( $args->has_children && 0 === $depth ) {
					$atts['href']           = '#';
					$atts['data-bs-toggle'] = 'dropdown';
					$atts['class']          = 'nav-link dropdown-toggle';
					$atts['aria-expanded']  = 'false';
				} else {
					$atts['href'] = ! empty( $item->url ) ? $item->url : '';
					if ( $depth > 0 ) {
						$atts['class'] = 'dropdown-item'; // Dropdown item.
					} else {
						$atts['class'] = 'nav-link'; // First level.
					}
					if ( in_array( 'current-menu-item', $classes ) ) {
						$atts['class'] .= ' active';
						$atts['aria-current']  = 'page';
					}
				}
				$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
				$attributes = '';
				foreach ( $atts as $attr => $value ) {
					if ( ! empty( $value ) ) {
						$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
				$item_output = $args->before;

				/*
				 * Glyphicons/Font-Awesome
				 * ===========
				 * Since the the menu item is NOT a Divider or Header we check the see
				 * if there is a value in the attr_title property. If the attr_title
				 * property is NOT null we apply it as the class name for the glyphicon.
				 */
				if ( ! empty( $item->attr_title ) ) {
					$pos = strpos( esc_attr( $item->attr_title ), 'glyphicon' );
					if ( false !== $pos ) {
						$item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></span>&nbsp;';
					} else {
						$item_output .= '<a' . $attributes . '><i class="fa ' . esc_attr( $item->attr_title ) . '" aria-hidden="true"></i>&nbsp;';
					}
				} else {
					$item_output .= '<a' . $attributes . '>';
				}
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
				$item_output .= $args->after;
				$output      .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}

		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth.
		 *
		 * This method shouldn't be called directly, use the walk() method instead.
		 */
		public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			if ( ! $element ) {
				return;
			}
			$id_field = $this->db_fields['id'];
			// Display this element.
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
			}
			parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		/**
		 * Menu Fallback
		 * =============
		 * If this function is assigned to the wp_nav_menu's fallback_cb variable
		 * and a menu has not been assigned to the theme location in the WordPress
		 * menu manager the function with display nothing to a non-logged in user,
		 * and will add a link to the WordPress menu manager if logged in as an admin.
		 */
		public static function fallback( $args ) {
			if ( current_user_can( 'edit_theme_options' ) ) {
				$container       = $args['container'];
				$container_id    = $args['container_id'];
				$container_class = $args['container_class'];
				$menu_class      = $args['menu_class'];
				$menu_id         = $args['menu_id'];

				$output = '';

				if ( $container ) {
					$output .= '<' . esc_attr( $container ) . ( $container_class ? ' class="' . esc_attr( $container_class ) . '"' : '' ) . '>';
				}
				$output .= '<ul' . ( $menu_class ? ' class="' . esc_attr( $menu_class ) . '"' : '' ) . '>';
					$output .= '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="">' . esc_html__( 'Add a menu', 'clevermatch' ) . '</a></li>';
				$output .= '</ul>';
				if ( $container ) {
					$output .= '</' . esc_attr( $container ) . '>';
				}

				echo $output;
			}
		}
	}
}

/**
 * Menu Cleanup
 * =============
 */
function custom_wp_nav_menu($var) {
	return is_array($var) ? array_intersect($var, array(
		//List of allowed menu classes
		'current_page_item',
		'current_page_parent',
		'current_page_ancestor',
		'dropdown',
		'nav-item',
		'menu-item'
		)
	) : '';
}
add_filter('nav_menu_css_class', 'custom_wp_nav_menu');
add_filter('nav_menu_item_id', 'custom_wp_nav_menu');
add_filter('page_css_class', 'custom_wp_nav_menu');
 
//Replaces "current-menu-item" with "active"
function current_to_active($text){
	$replace = array(
		//List of menu item classes that should be changed to "active"
		'current_page_item' => 'active',
		'current_page_parent' => 'active',
		'current_page_ancestor' => 'active',
	);
	$text = str_replace(array_keys($replace), $replace, $text);
		return $text;
	}
add_filter ('wp_nav_menu','current_to_active');
 
//Deletes empty classes and removes the sub menu class
function strip_empty_classes($menu) {
	$menu = preg_replace('/ class=""| class="sub-menu"/','',$menu);
	return $menu;
}
add_filter ('wp_nav_menu','strip_empty_classes');

