<?php
/*
Plugin Name: CleverMatch Jobs
Description: Zeigt Jobangebote aus dem CleverMatch JSON-Feed als Bootstrap Cards an
Version: 1.5
Author: getniemeyer
Author URI: https://www.getniemeyer.de
*/
defined('ABSPATH') or die('Direkter Zugriff nicht erlaubt!');

if (!defined('CLEVERMATCH_API_KEY')) {
		define('CLEVERMATCH_API_KEY', '96fd4d83bcfd0d65034e61f086f81bbbe4d025a3e75d8a625ec68aeffe042adf');
}

	define('CLEVERMATCH_JOBS_PLUGIN_DIR', plugin_dir_path(__FILE__));
	define('CLEVERMATCH_JOBS_PLUGIN_URL', plugin_dir_url(__FILE__));
	
if (!defined('CLEVERMATCH_JOBS_CACHE_DIR')) {
		define('CLEVERMATCH_JOBS_CACHE_DIR', WP_CONTENT_DIR . '/cache/clevermatch-jobs-plugin');
}

require_once CLEVERMATCH_JOBS_PLUGIN_DIR . 'includes/class-clevermatch-jobs.php';
require_once CLEVERMATCH_JOBS_PLUGIN_DIR . 'includes/class-clevermatch-jobs-api.php';
require_once CLEVERMATCH_JOBS_PLUGIN_DIR . 'includes/class-clevermatch-jobs-shortcode.php';
require_once CLEVERMATCH_JOBS_PLUGIN_DIR . 'includes/affiliate-tracker.php';

if (!class_exists('CleverMatch_Affiliate_API')) {
		require_once CLEVERMATCH_JOBS_PLUGIN_DIR . 'includes/affiliate-api.php';
}

add_filter('theme_page_templates', function($templates) {
		$templates['cm-dashboard.php'] = 'Affiliate Home';
		return $templates;
});

add_filter('page_template', function($template) {
		if (is_page_template('cm-dashboard.php')) {
				return CLEVERMATCH_JOBS_PLUGIN_DIR . 'cm-dashboard.php';
		}
		return $template;
});

function clevermatch_jobs_init() {
		if (!file_exists(CLEVERMATCH_JOBS_CACHE_DIR)) {
				if (!wp_mkdir_p(CLEVERMATCH_JOBS_CACHE_DIR)) {
						error_log('CleverMatch: Unable to create cache directory.');
				}
		}
		CleverMatch_Jobs::get_instance();
		CleverMatch_Jobs_Affiliate_Tracker::init();
}
add_action('plugins_loaded', 'clevermatch_jobs_init');


// ==============================================
// TEMPORÄRE FUNKTIONEN FÜR TESTS (SPÄTER ERSETZEN)

/* Simuliert die CM-Login-Prüfung über Cookies */
if (!function_exists('clevermatch_check_cm_login')) {
		function clevermatch_check_cm_login() {
				return isset($_COOKIE['cm_temp_logged_in']);
		}
}

if (!function_exists('cm_validate_afpid')) {
		function cm_validate_afpid($afpid) {
				error_log('Simulierte AFPID-Validierung: ' . $afpid);
				return true;
		}
}

// ==============================================


// Function to get cached API response
function clevermatch_jobs_get_cached_api_response($cache_key) {
		$cache_file = CLEVERMATCH_JOBS_CACHE_DIR . '/' . sanitize_file_name($cache_key) . '.json';
		
		if (file_exists($cache_file) && (time() - filemtime($cache_file) < 16 * MINUTE_IN_SECONDS)) {
				$cached_data = file_get_contents($cache_file);
				return $cached_data ? json_decode($cached_data, true) : false;
		}
		
		return false;
}

// Function to set cached API response
function clevermatch_jobs_set_cached_api_response($cache_key, $data) {
		if (!file_exists(CLEVERMATCH_JOBS_CACHE_DIR)) {
				wp_mkdir_p(CLEVERMATCH_JOBS_CACHE_DIR);
		}
		$cache_file = CLEVERMATCH_JOBS_CACHE_DIR . '/' . sanitize_file_name($cache_key) . '.json';
		file_put_contents($cache_file, json_encode($data));
}

// Function to get last cached API response
function clevermatch_jobs_get_last_cached_api_response() {
		$files = glob(CLEVERMATCH_JOBS_CACHE_DIR . '/*.json');
		if (!empty($files)) {
				$latest_file = max($files);
				return json_decode(file_get_contents($latest_file), true);
		}
		return false;
}

// Function to clear the cache
function clevermatch_jobs_clear_cache() {
		$files = glob(CLEVERMATCH_JOBS_CACHE_DIR . '/*.json');
		foreach ($files as $file) {
				if (is_file($file)) {
						unlink($file);
				}
		}
}

// Function to clean up old cache files
function clevermatch_jobs_cleanup_cache() {
		$files = glob(CLEVERMATCH_JOBS_CACHE_DIR . '/*.json');
		$now = time();
		foreach ($files as $file) {
				if (is_file($file) && ($now - filemtime($file) > 16 * MINUTE_IN_SECONDS)) {
						unlink($file);
				}
		}
}

// Schedule cache cleanup
register_deactivation_hook(__FILE__, function() {
		wp_clear_scheduled_hook('clevermatch_jobs_cache_cleanup');
});

if (!wp_next_scheduled('clevermatch_jobs_cache_cleanup')) {
		wp_schedule_event(time(), 'daily', 'clevermatch_jobs_cache_cleanup');
}
add_action('clevermatch_jobs_cache_cleanup', 'clevermatch_jobs_cleanup_cache');


// Add Affiliate Link to URLs
function clevermatch_jobs_append_afid_to_job_url($url) {
		if (!empty($_COOKIE['afid'])) {
				$url = add_query_arg('afid', sanitize_text_field($_COOKIE['afid']), $url);
		}
		return remove_query_arg('afpid', $url);
}
add_filter('clevermatch_job_apply_url', 'clevermatch_jobs_append_afid_to_job_url');


// Output Buffer, um die afid dynamisch an alle internen Links anzuhängen
function clevermatch_append_afid_to_all_links($content) {
		if (!empty($_COOKIE['afid'])) {
				$afid = sanitize_text_field($_COOKIE['afid']);
				$content = preg_replace_callback(
						'/href=(["\'])(https?:\/\/' . preg_quote($_SERVER['HTTP_HOST'], '/') . '[^"\']*?)\1/',
						function ($m) use ($afid) {
								return 'href="' . add_query_arg('afid', $afid, $m[2]) . '"';
						},
						$content
				);
		}
		return $content;
}
add_filter('the_content', 'clevermatch_append_afid_to_all_links');
add_filter('widget_text', 'clevermatch_append_afid_to_all_links');
add_filter('wp_nav_menu', 'clevermatch_append_afid_to_all_links');


// AJAX-Handler
function handle_ajax_request($required_fields) {
		check_ajax_referer('clevermatch_ajax_nonce', 'security');
		
		$errors = [];
		foreach ($required_fields as $field) {
				if (empty($_POST[$field])) {
						$errors[$field] = "Bitte füllen Sie dieses Feld aus.";
				}
		}
		
		if (!empty($errors)) {
				wp_send_json_error(['errors' => $errors], 400);
		}
		return true;
}

// Empfehlungsformular
add_action('wp_ajax_empfehlung_senden', 'empfehlung_senden_handler');
add_action('wp_ajax_nopriv_empfehlung_senden', 'empfehlung_senden_handler');

function empfehlung_senden_handler() {
		if (!handle_ajax_request(['CompanyName', 'Address1', 'Address2', 'PostalCode', 'City', 'Country', 'radio1', 'radio2', 'Title', 'FirstName', 'LastName', 'PhoneNumberOffice', 'Email', 'Textarea', 'Partner', 'DoNotDiscloseReferrer'])) return;
		
		// Datenverarbeitung hier einfügen
		wp_send_json_success([
				'message' => 'Empfehlung erfolgreich gesendet!',
				'data' => array_map('sanitize_text_field', $_POST)
		]);
		wp_die();
}

// Profilaktualisierung
add_action('wp_ajax_profil_aktualisieren', 'profil_aktualisieren_handler');
add_action('wp_ajax_nopriv_profil_aktualisieren', 'profil_aktualisieren_handler');

function profil_aktualisieren_handler() {
		if (!handle_ajax_request(['radio1', 'radio2', 'Title', 'FirstName', 'LastName', 'Email', 'PhoneNumberOffice', 'CompanyName', 'AccountHolder', 'Bank', 'IBAN', 'BIC'])) return;
		
		// Datenverarbeitung hier einfügen
		wp_send_json_success([
				'message' => 'Profil erfolgreich aktualisiert!',
				'data' => array_map('sanitize_text_field', $_POST)
		]);
		wp_die();
}

// ==============================================
// ZUKÜNFTIGE API-INTEGRATION (AUSKOMMENTIERT)
// ==============================================
/*
function clevermatch_check_cm_login() {
		// API-Endpunkt vom CM-Team bestätigen
		$response = wp_remote_get('https://api.clevermatch.com/auth/check', [
				'headers' => [
						'Authorization' => 'Bearer ' . CLEVERMATCH_API_KEY,
						'Cookie' => implode('; ', $_COOKIE)
				],
				'timeout' => 5
		]);
		
		if (!is_wp_error($response) && $response['response']['code'] === 200) {
				$body = json_decode($response['body'], true);
				return $body['logged_in'] ?? false;
		}
		return false;
}

function cm_validate_afpid($afpid) {
		$response = wp_remote_get('https://api.clevermatch.com/v1/validate-afpid/' . $afpid, [
				'headers' => [
						'Authorization' => 'Bearer ' . CLEVERMATCH_API_KEY,
						'Accept' => 'application/json'
				],
				'timeout' => 5
		]);

		if (!is_wp_error($response) && $response['response']['code'] === 200) {
				$body = json_decode($response['body'], true);
				return $body['isValid'] ?? false;
		}
		return false;
}
*/
