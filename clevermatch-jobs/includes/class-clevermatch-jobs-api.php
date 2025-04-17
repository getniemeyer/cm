<?php
class CleverMatch_Jobs_API {
		
		private static $default_feed_url = 'https://jobs.clevermatch.com/de/Feeds/CareerPage/';
		private static $special_feed_url = 'https://jobs.clevermatch.com/de/Feeds/Json/Sp/f8ad133b-d83a-46b6-bd9d-c2f80f38ff9b/';
		private static $max_cache_age = 24 * HOUR_IN_SECONDS;

		public static function get_jobs($partner = null, $use_special_feed = false, $limit = null) {
				if (!defined('CLEVERMATCH_API_KEY') || !defined('CLEVERMATCH_JOBS_CACHE_DIR')) {
						error_log('CleverMatch: Required constants are not defined.');
						return array();
				}

				$cache_key = 'clevermatch_jobs_' . md5(serialize($partner) . $use_special_feed);
				$cache_file = CLEVERMATCH_JOBS_CACHE_DIR . '/' . $cache_key . '.json';

				$cached_jobs = self::get_last_valid_cache();
				if ($cached_jobs !== false) {
						error_log("Using cached jobs. Count: " . count($cached_jobs));
						return $cached_jobs;
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
						$error_message = $response->get_error_message();
						error_log("CleverMatch API Error: {$error_message}");
						$cached_jobs = self::get_last_valid_cache(self::$max_cache_age);
						if ($cached_jobs !== false) {
								error_log("Using cached jobs due to API error");
								return $cached_jobs;
						}
						return array();
				}

				$body = wp_remote_retrieve_body($response);
				error_log("CleverMatch API Response: " . substr($body, 0, 150));
				
				$data = json_decode($body, true);
				if (function_exists('json_last_error') && json_last_error() !== JSON_ERROR_NONE) {
						error_log('CleverMatch JSON Decode Error: ' . json_last_error_msg());
						return array();
				}

				$jobs = isset($data['Jobs']) ? $data['Jobs'] : array();
					error_log("Total jobs loaded from API: " . count($jobs));
				if ($partner) {
						$jobs = array_filter($jobs, function($job) use ($partner) {
								return isset($job['Partner']) && $job['Partner'] === $partner;
						});
				}

				$context = $use_special_feed ? "Special feed" : "Default feed";
				$context .= $partner ? " for partner: {$partner}" : "";
				$jobs = self::check_job_count($jobs, $context, $limit);

				foreach ($jobs as &$job) {
						$job['ApplyUrl'] = apply_filters('clevermatch_job_apply_url', $job['ApplyUrl']);
				}

				if (!file_exists(CLEVERMATCH_JOBS_CACHE_DIR)) {
						if (!wp_mkdir_p(CLEVERMATCH_JOBS_CACHE_DIR)) {
								error_log('CleverMatch: Unable to create cache directory.');
								return $jobs;
						}
				}
				if (file_put_contents($cache_file, json_encode($jobs)) === false) {
								error_log('CleverMatch: Unable to write to cache file: ' . $cache_file);
						} else {
								error_log('CleverMatch: Successfully cached ' . count($jobs) . ' jobs to ' . $cache_file);
						}
				
				if ($limit !== null && is_numeric($limit)) {
						$jobs = array_slice($jobs, 0, intval($limit));
				}

						return $jobs;
				}

				public static function check_job_count($jobs, $context = '', $limit = null) {
						$job_count = count($jobs);
						$is_special_feed = strpos($context, 'Special feed') !== false;
						$is_partner_specific = strpos($context, 'for partner:') !== false;
				
						// Nur für den Haupt-Feed (nicht special, nicht partner-spezifisch) prüfen
						if (!$is_special_feed && !$is_partner_specific && $limit === null) {
								if ($job_count < 30) {
										$message = "CleverMatch Warning: Only {$job_count} jobs loaded for main feed. Minimum expected is 30. Context: {$context}";
										error_log($message);
										
										$to = get_option('admin_email');
										$subject = 'CleverMatch Main Feed Warning';
										wp_mail($to, $subject, $message);
								}
						} else if ($job_count == 0) {
								// Für alle anderen Fälle nur warnen, wenn gar keine Jobs geladen wurden
								$message = "CleverMatch Warning: No jobs loaded. Context: {$context}";
								error_log($message);
								
								$to = get_option('admin_email');
								$subject = 'CleverMatch Feed Warning';
								wp_mail($to, $subject, $message);
						}
				
						return $jobs;
				}

		public static function get_last_valid_cache($max_age = null) {
				if ($max_age === null) {
						$max_age = self::$max_cache_age;
				}
				$files = glob(CLEVERMATCH_JOBS_CACHE_DIR . '/*.json');
				if (empty($files)) return false;

				usort($files, function($a, $b) {
						return filemtime($b) - filemtime($a);
				});

				$now = time();
				for ($i = 0; $i < min(5, count($files)); $i++) {
						if ($now - filemtime($files[$i]) <= $max_age) {
								$data = json_decode(file_get_contents($files[$i]), true);
								if (json_last_error() === JSON_ERROR_NONE && isset($data['Jobs'])) {
										return $data['Jobs'];
								}
						}
				}

				return false;
		}
}