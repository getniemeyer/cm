<?php
function set_affiliate_cookie() {
		if (isset($_GET['afid']) && !empty($_GET['afid'])) {
				$afid = sanitize_text_field($_GET['afid']);
				setcookie('afid', $afid, time() + (60 * 24 * 60 * 60), '/', 'clevermatch.com', true, true);
		}
		if (isset($_GET['afid'])) {
				$redirect_url = add_query_arg('afid', $_GET['afid'], $redirect_url);
		}
		if (isset($_GET['afpid']) && !empty($_GET['afpid'])) {
				$afpid = sanitize_text_field($_GET['afpid']);
				setcookie('afpid', $afpid, time() + (60 * 24 * 60 * 60), '/', 'clevermatch.com', true, true);
		}
		if (isset($_GET['afpid'])) {
				$redirect_url = add_query_arg('afpid', $_GET['afpid'], $redirect_url);
		}
		error_log('Affiliate cookie set: ' . (isset($_GET['afid']) ? $_GET['afid'] : '') . ', ' . (isset($_GET['afpid']) ? $_GET['afpid'] : ''));
}

add_action('init', 'set_affiliate_cookie');
