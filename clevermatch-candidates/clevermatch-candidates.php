<?php
/*
Plugin Name: CleverMatch Candidates
Description: Zeigt Kandidaten aus dem CleverMatch JSON Feed mit Filter Optionen, Caching und Paginierung
Version: 1.2.5
Author: getniemeyer
Author URI: https://www.getniemeyer.de
*/
defined('ABSPATH') or die('Direkter Zugriff nicht erlaubt!');

if (!defined('CLEVERMATCH_API_KEY')) {
    define('CLEVERMATCH_API_KEY', '96fd4d83bcfd0d65034e61f086f81bbbe4d025a3e75d8a625ec68aeffe042adf');
}

require_once plugin_dir_path(__FILE__) . 'affiliate-tracker.php';
CleverMatch_Candidates_Affiliate_Tracker::init();

// Enqueue Scripts und Styles
function clevermatch_enqueue_scripts() {
    wp_enqueue_style('candidates-style', plugin_dir_url(__FILE__) . 'assets/css/candidates-styles.css', array('bootstrap'), '1.2.5', 'all');
    wp_enqueue_script('candidates-script', plugin_dir_url(__FILE__) . 'assets/js/candidates-script.js', array('jquery'), '1.2.5', true);
    wp_localize_script('candidates-script', 'clevermatch_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'afid' => isset($_COOKIE['afid']) ? sanitize_text_field($_COOKIE['afid']) : ''
    ));
}
add_action('wp_enqueue_scripts', 'clevermatch_enqueue_scripts');

// Shortcode zum Anzeigen der Kandidaten 
function clevermatch_candidates_shortcode($atts = []) {
    $atts = shortcode_atts(array(
        'limit' => 0,
        'show_count' => 'true'
    ), $atts);

    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/candidates-template.php');
    $output = ob_get_clean();

    return str_replace(
        'id="cmCandidatesContainer"', 
        'id="cmCandidatesContainer" data-limit="'.esc_attr($atts['limit']).'" data-show-count="'.esc_attr($atts['show_count']).'"', 
        $output
    );
}
add_shortcode('clevermatch_candidates', 'clevermatch_candidates_shortcode');

function clevermatch_candidates_limited_shortcode($atts = []) {
    $atts = shortcode_atts(array(
        'limit' => 3,
        'show_count' => $options['clevermatch_show_count'] ?? 'true'
    ), $atts);

    return clevermatch_candidates_shortcode($atts);
}
add_shortcode('clevermatch_candidates_limited', 'clevermatch_candidates_limited_shortcode');

// AJAX Handler zum Fetchen der Kandidaten 
add_action('wp_ajax_clevermatch_fetch_candidates', 'clevermatch_fetch_candidates');
add_action('wp_ajax_nopriv_clevermatch_fetch_candidates', 'clevermatch_fetch_candidates');

function clevermatch_fetch_candidates() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $pagesize = 50;
    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : null;

    $cache_key = 'clevermatch_candidates_' . md5(serialize($_POST));
    $data = get_cached_api_response($cache_key);

    if ($data === false) {
        $url = 'https://jobs.clevermatch.com/de/feeds/candidates/?v=2&iq=true&ps=' . $pagesize . '&p=' . $page;
    
        $params = array();
        $filter_fields = array('industry', 'location', 'keyword', 'fieldOfWork', 'seniority');
        foreach ($filter_fields as $field) {
            if (!empty($_POST[$field])) {
                $values = is_array($_POST[$field]) ? $_POST[$field] : explode(',', $_POST[$field]);
                foreach ($values as $value) {
                    if (!empty($value)) {
                        $params[] = $field . '=' . urlencode(sanitize_text_field($value));
                    }
                }
            }
        }

        if (!empty($_POST['salary_min'])) {
            $params[] = 'salary_min=' . urlencode(sanitize_text_field($_POST['salary_min']));
        }
        if (!empty($_POST['salary_max'])) {
            $params[] = 'salary_max=' . urlencode(sanitize_text_field($_POST['salary_max']));
        }
    
        $query_string = implode('&', $params);
        $full_url = $url . '&' . $query_string;
        
        error_log('Full API URL: ' . $full_url);
    
        $args = array(
            'method'  => 'POST',
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'API-Key' => CLEVERMATCH_API_KEY
            ),
            'body'    => $query_string,
            'timeout' => 30,
            'user-agent' => 'JCI WordPress-Plugin',
        );        
    
        $response = wp_remote_get($url, $args);
        
        if (!empty($data['candidates'])) {
            $data['candidates'] = array_map(function($candidate) {
                return [
                    'Title' => $candidate['Title'],
                    'Age' => $candidate['Age'],
                    'Region' => $candidate['Region'],
                    'SalaryExpectations' => $candidate['SalaryExpectations'],
                    'Industry' => $candidate['Industry'],
                    'CertificationLevel' => $candidate['CertificationLevel'],
                    'Url' => $candidate['Url']
                ];
            }, $data['candidates']);
        }
        
        if (is_wp_error($response)) {
        error_log('API request error: ' . $response->get_error_message());
        $data = get_last_valid_cache();
        if ($data === false) {
            wp_send_json_error('Error fetching candidates and no valid cache available');
            return;
        }
    
        } else {
                $response_body = wp_remote_retrieve_body($response);
                $data = json_decode($response_body, true);
            
                if (json_last_error() !== JSON_ERROR_NONE) {
                    error_log('JSON parsing error: ' . json_last_error_msg());
                    $data = get_last_valid_cache();
                    if ($data === false) {
                        wp_send_json_error('Invalid response from API and no valid cache available');
                        return;
                    }
                } else {
                    // Speichert die Gesamtzahl der Kandidaten
                    $total_candidates = isset($data['totalno']) ? $data['totalno'] : count($data['candidates']);
                    
                    // Anwenden des Limits, falls vorhanden
                    $limit = isset($_POST['limit']) ? intval($_POST['limit']) : null;
                    
                    $data['pagesize'] = $pagesize;
                    $data['page'] = $page;
                    $data['totalno'] = $total_candidates; 
                    $data['totalpages'] = ceil($total_candidates / $pagesize);
                    
                    set_cached_api_response($cache_key, $data);
                }
            }
        }
    
            wp_send_json_success($data);
        }
        
        function get_last_valid_cache() {
            $files = glob(CLEVERMATCH_CACHE_DIR . '*.json');
            if (empty($files)) return false;
        
            // Sortieren der Dateien nach Änderungsdatum, neueste zuerst
            usort($files, function($a, $b) {
                return filemtime($b) - filemtime($a);
            });
        
            // Überprüfen der 5 neuesten Dateien
            for ($i = 0; $i < min(5, count($files)); $i++) {
                $data = json_decode(file_get_contents($files[$i]), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $data;
                }
            }
        
            return false;
        }
        

// Function to get cached API response
function get_cached_api_response($cache_key) {
    $cache_dir = WP_CONTENT_DIR . '/cache/clevermatch-candidates-plugin/';
    $cache_file = $cache_dir . sanitize_file_name($cache_key) . '.json';
    
    if (file_exists($cache_file) && (time() - filemtime($cache_file) < 16 * 60)) {
        $cached_data = file_get_contents($cache_file);
        return $cached_data ? json_decode($cached_data, true) : false;
    }
    
    return false;
}

// Function to set cached API response
function set_cached_api_response($cache_key, $data) {
    $cache_dir = WP_CONTENT_DIR . '/cache/clevermatch-candidates-plugin/';
    if (!file_exists($cache_dir)) {
        wp_mkdir_p($cache_dir);
    }
    $cache_file = $cache_dir . sanitize_file_name($cache_key) . '.json';
    file_put_contents($cache_file, json_encode($data));
}

// Function to get last cached API response
function get_last_cached_api_response() {
    $cache_dir = WP_CONTENT_DIR . '/cache/clevermatch-candidates-plugin/';
    $files = glob($cache_dir . '*.json');
    if (!empty($files)) {
        $latest_file = max($files);
        return json_decode(file_get_contents($latest_file), true);
    }
    return false;
}

// Function to clear the cache
function clevermatch_clear_cache() {
    $cache_dir = WP_CONTENT_DIR . '/cache/clevermatch-candidates-plugin/';
    $files = glob($cache_dir . '*.json');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
}

// Function to clean up old cache files
function clevermatch_cleanup_cache() {
    $cache_dir = WP_CONTENT_DIR . '/cache/clevermatch-candidates-plugin/';
    $files = glob($cache_dir . '*.json');
    $now = time();
    foreach ($files as $file) {
        if (is_file($file) && ($now - filemtime($file) > 24 * 60 * 60)) { // Delete files older than 24 hours
            unlink($file);
        }
    }
}

// Schedule cache cleanup
if (!wp_next_scheduled('clevermatch_cache_cleanup')) {
    wp_schedule_event(time(), 'daily', 'clevermatch_cache_cleanup');
}
add_action('clevermatch_cache_cleanup', 'clevermatch_cleanup_cache');


// Add Affiliate Cookie for Users
function set_afid_cookie() {
    if (isset($_GET['afid'])) {
        $afid = sanitize_text_field($_GET['afid']);
        setcookie('afid', $afid, time() + 30 * 24 * 60 * 60, '/', 'clevermatch.com', true, true);
    }
}
add_action('init', 'set_afid_cookie');

// Add Affiliate Link to URLs
function append_afid_to_candidate_url($url) {
    if (isset($_COOKIE['afid'])) {
        $afid = sanitize_text_field($_COOKIE['afid']);
        $url = add_query_arg('afid', $afid, $url);
    }
    return $url;
}
