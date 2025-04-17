<?php
class CleverMatch_Jobs_Shortcode {
		public static function output($atts) {
				$atts = shortcode_atts(array(
						'partner' => '',
						'use_special_feed' => 'false',
						'limit' => 0
				), $atts);

				$use_special_feed = filter_var($atts['use_special_feed'], FILTER_VALIDATE_BOOLEAN);
				$jobs = CleverMatch_Jobs_API::get_jobs($atts['partner'], $use_special_feed);

				if ($atts['limit'] > 0) {
						$jobs = array_slice($jobs, 0, $atts['limit']);
				}

				ob_start();

				// Nur für AFPID-Benutzer
				if (CleverMatch_Jobs::has_afpid()) {
						include(CLEVERMATCH_JOBS_PLUGIN_DIR . 'templates/jobs-template-share.php');
				} else {
						// Für alle anderen (inkl. AFID-Benutzer und nicht eingeloggte User)
						if ($use_special_feed) {
								include(CLEVERMATCH_JOBS_PLUGIN_DIR . 'templates/gj-jobs-template.php');
						} elseif (!empty($atts['partner'])) {
								include(CLEVERMATCH_JOBS_PLUGIN_DIR . 'templates/partner-jobs-template.php');
						} else {
								include(CLEVERMATCH_JOBS_PLUGIN_DIR . 'templates/jobs-template.php');
						}
				}

				return ob_get_clean();
		}
}
