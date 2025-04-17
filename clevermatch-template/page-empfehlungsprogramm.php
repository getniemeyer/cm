<?php
/**
 * Template Name: Seite Empfehlungsprogramm
 * Description: Template für die Empfehlungsprogramm-Seite.
 */
get_header();

// Prüfen Sie den User-Status
$has_afid = isset($_COOKIE['afid']) && !empty($_COOKIE['afid']);
$has_afpid = isset($_COOKIE['afpid']) && !empty($_COOKIE['afpid']);
$is_logged_in = isset($_COOKIE['loggedInCM']) && !empty($_COOKIE['loggedInCM']); // LoggedIn-Cookie von CM

if ($has_afpid) {
		// Zustand B: Affiliate-Menü anzeigen
		include('inc-affiliate/affiliate-menu.php');
		
		// Weiterleitung zur Login-Seite bei Link-Klick
} elseif ($is_logged_in && !$has_afid && !$has_afpid) {
		// Zustand C: Kein Login-Link anzeigen
		include('inc-affiliate/programm.php');
		include('inc-affiliate/form-registrierung-b.php');
		include('inc-affiliate/add-ons.php');
		include('inc-affiliate/faq.php');
		
} elseif ($is_logged_in && $has_afpid) {
		// Zustand D: Direkt zum Dashboard weiterleiten
		wp_redirect('https://www.getniemeyer.de/projects/cleverneu/empfehlungsportal/');
		exit;
		
} else {
		// Zustand A: Standard-Anzeige
		include('inc-affiliate/programm.php');
		include('inc-affiliate/form-registrierung-a.php');
		include('inc-affiliate/add-ons.php');
		include('inc-affiliate/faq.php');
}

get_footer();
?>
