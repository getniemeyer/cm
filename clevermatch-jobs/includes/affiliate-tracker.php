<?php
class CleverMatch_Jobs_Affiliate_Tracker {
		public static function init() {
				add_action('init', array(__CLASS__, 'set_affiliate_cookies'));
		}

		public static function set_affiliate_cookies() {
				// Cookie-Lebensdauer in Sekunden (60 Tage)
				$cookie_lifetime = 60 * 24 * 60 * 60;

				// AFID (Empfehlungs-ID) setzen/verlängern
				if (isset($_GET['afid'])) {
						$afid = sanitize_text_field($_GET['afid']);
						setcookie(
								'afid',
								$afid,
								time() + $cookie_lifetime,
								'/',
								$_SERVER['HTTP_HOST'], // Dynamische Domain
								is_ssl(), // Nur über HTTPS
								true      // HttpOnly
						);
				}

				// AFPID (Empfehler-ID) setzen/verlängern
				if (isset($_GET['afpid'])) {
						$afpid = sanitize_text_field($_GET['afpid']);
						setcookie(
								'afpid',
								$afpid,
								time() + $cookie_lifetime,
								'/',
								$_SERVER['HTTP_HOST'], // Dynamische Domain
								is_ssl(), // Nur über HTTPS
								true      // HttpOnly
						);
				}
		}
}
