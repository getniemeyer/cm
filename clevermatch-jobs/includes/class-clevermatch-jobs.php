<?php
class CleverMatch_Jobs {
		private static $instance;

		public static function get_instance() {
				if (null === self::$instance) {
						self::$instance = new self();
				}
				return self::$instance;
		}

		private function __construct() {
				$this->init_hooks();
		}

		private function init_hooks() {
				add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
				add_action('init', array($this, 'register_shortcodes'));
		}

		public function enqueue_scripts() {
				wp_enqueue_style('jobs-style', 
						CLEVERMATCH_JOBS_PLUGIN_URL . 'assets/css/jobs-styles.css', 
						array('bootstrap'), 
						'1.5'
				);
				
				wp_enqueue_script('jobs-script', 
						CLEVERMATCH_JOBS_PLUGIN_URL . 'assets/js/jobs-script.js', 
						array('jquery'), 
						'1.5', 
						true
				);
				
				wp_localize_script('jobs-script', 'clevermatch_jobs_ajax', array(
						'ajax_url' => admin_url('admin-ajax.php')
				));
		
				// Scripts für Formulare
				$this->enqueue_form_scripts('form-empfehlung');
				$this->enqueue_form_scripts('form-profil');
		}
		
		private function enqueue_form_scripts($handle) {
				wp_enqueue_script(
						$handle,
						CLEVERMATCH_JOBS_PLUGIN_URL . 'assets/js/' . $handle . '.js',
						array('jquery'),
						'1.5',
						true
				);
				
				wp_localize_script($handle, 'ajax_object', array(
						'ajax_url' => admin_url('admin-ajax.php')
				));
		}

		public function register_shortcodes() {
				add_shortcode('clevermatch_jobs', array('CleverMatch_Jobs_Shortcode', 'output'));
				add_shortcode('form-empfehlung', array($this, 'render_empfehlung_form'));
				add_shortcode('form-profil', array($this, 'render_profil_form'));
		}		

		public function render_empfehlung_form() {
				include(CLEVERMATCH_JOBS_PLUGIN_DIR . 'cm-form-empfehlung.php');
		}
		
		public function render_profil_form() {
				include(CLEVERMATCH_JOBS_PLUGIN_DIR . 'cm-form-profil.php');
		}
		
		// AFPID-Überprüfung
		public static function has_afpid() {
				return isset($_COOKIE['afpid']) && !empty($_COOKIE['afpid']);
		}
		
		// Überarbeitete User-Status-Prüfung
		public static function is_user_logged_in_or_has_affiliate_id() {
				return is_user_logged_in() || self::has_afpid();
		}
}
