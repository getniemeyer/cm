<?php
class CleverMatch_Candidates_Affiliate_Tracker {
	
		const COOKIE_DURATION = 8 * 7 * 24 * 60 * 60; // 60 Tage

		public static function init() {
				add_action('init', array(__CLASS__, 'set_affiliate_cookie'));
				add_filter('clevermatch_candidate_apply_url', array(__CLASS__, 'append_afid_to_candidate_links'));
		}

		public static function set_affiliate_cookie() {
				if (isset($_GET['afid']) && !empty($_GET['afid'])) {
						$afid = sanitize_text_field($_GET['afid']);
						setcookie('afid', $afpid, time() + self::COOKIE_DURATION, '/', 'clevermatch.com', true, true);
				}
				if (isset($_GET['afpid']) && !empty($_GET['afpid'])) {
						$afid = sanitize_text_field($_GET['afid']);
						setcookie('afpid', $afpid, time() + self::COOKIE_DURATION, '/', 'clevermatch.com', true, true);
				}
		}

		public static function append_afid_to_candidate_links($candidate_url) {
				if (isset($_COOKIE['afid'])) {
						$afid = sanitize_text_field($_COOKIE['afid']);
						$candidate_url = add_query_arg('afid', $afid, $candidate_url);
				}
				if (isset($_COOKIE['afpid'])) {
						$afpid = sanitize_text_field($_COOKIE['afpid']);
						$candidate_url = add_query_arg('afpid', $afid, $candidate_url);
				}
				return $candidate_url;
		}
}