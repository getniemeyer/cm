<?php
class CleverMatch_Jobs_API {
		
		private static $default_feed_url = 'https://jobs.clevermatch.com/de/Feeds/CareerPage/';
		private static $special_feed_url = 'https://jobs.clevermatch.com/de/Feeds/Json/Sp/f8ad133b-d83a-46b6-bd9d-c2f80f38ff9b/';

		public static function get_jobs($partner = null, $use_special_feed = false) {
				if (!defined('CLEVERMATCH_API_KEY') || !defined('CLEVERMATCH_JOBS_CACHE_DIR')) {
						error_log('CleverMatch: Required constants are not defined.');
						return array();
				}

				$cache_key = 'clevermatch_jobs_' . md5(serialize($partner) . $use_special_feed);
				$cache_file = CLEVERMATCH_JOBS_CACHE_DIR . '/' . $cache_key . '.json';
		
				if (file_exists($cache_file) && (time() - filemtime($cache_file) < 16 * MINUTE_IN_SECONDS)) {
						$cached_data = file_get_contents($cache_file);
						return json_decode($cached_data, true);
				}
		
				$url = $use_special_feed ? self::$special_feed_url : self::$default_feed_url;
		
				$args = array(
						'method' => 'GET',
						'headers' => array(
								'Content-Type' => 'application/json',
								'API-Key' => CLEVERMATCH_API_KEY
						),
						'timeout' => 30,
						'user-agent' => 'JCI WordPress-Plugin',
				);
		
				$response = wp_remote_get($url, $args);
				if (is_wp_error($response)) {
						error_log('CleverMatch API Error: ' . $response->get_error_message());
						return array();
				}
		
				$body = wp_remote_retrieve_body($response);
				$data = json_decode($body, true);
				if (function_exists('json_last_error') && json_last_error() !== JSON_ERROR_NONE) {
						error_log('CleverMatch JSON Decode Error: ' . json_last_error_msg());
						return array();
				}
		
				$jobs = isset($data['Jobs']) ? $data['Jobs'] : array();
				if ($partner) {
						$jobs = array_filter($jobs, function($job) use ($partner) {
								return isset($job['Partner']) && $job['Partner'] === $partner;
						});
				}
		
				foreach ($jobs as &$job) {
						$job['ApplyUrl'] = apply_filters('clevermatch_job_apply_url', $job['ApplyUrl']);
				}
		
				if (!file_exists(CLEVERMATCH_JOBS_CACHE_DIR)) {
						if (!mkdir(CLEVERMATCH_JOBS_CACHE_DIR, 0755, true)) {
								error_log('CleverMatch: Unable to create cache directory.');
								return $jobs;
						}
				}
				file_put_contents($cache_file, json_encode($jobs));
		
				return $jobs;
		}
}