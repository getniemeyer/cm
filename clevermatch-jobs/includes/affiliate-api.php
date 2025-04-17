<?php
if (!defined('ABSPATH')) exit;

class CleverMatch_Affiliate_API {
		
		const API_BASE_URL = 'https://jobs.clevermatch.com/de/job/AffiliateLoginStatus/'; // Beispiel-URL (vom CM-Team bestätigen)

		/**
		 * Validiert die AFPID über die CM-API
		 * @param string $afpid
		 * @return bool
		 */
		public static function validate_afpid($afpid) {
				// Input sanitization
				$afpid = sanitize_text_field($afpid);
				if (empty($afpid)) return false;

				// API-Endpunkt (vom CM-Team bestätigen)
				$url = self::API_BASE_URL . '/validate-afpid/' . $afpid;

				// API-Request
				$response = wp_remote_get($url, array(
						'headers' => array(
								'Authorization' => 'Bearer ' . CLEVERMATCH_API_KEY, // API-Key aus der Konstanten
								'Accept'        => 'application/json'
						),
						'timeout' => 5
				));

				// Fehlerbehandlung
				if (is_wp_error($response)) {
						error_log('CM API Fehler: ' . $response->get_error_message());
						return false;
				}

				// Statuscode prüfen
				$status_code = wp_remote_retrieve_response_code($response);
				if ($status_code !== 200) {
						error_log('CM API Fehler: Statuscode ' . $status_code);
						return false;
				}

				// Response validieren
				$body = json_decode(wp_remote_retrieve_body($response), true);
				return isset($body['isValid']) ? (bool)$body['isValid'] : false;
		}
}
