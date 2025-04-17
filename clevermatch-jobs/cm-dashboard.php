<?php
/**
 * Template Name: Affiliate Home
 */
get_header();
?>
<style>.cm--stage {display: none}</style>

<p class="small ms-4 mb-3">CleverMatch Empfehlungsprogramm</p>
<?php
wp_nav_menu(array(
		'theme_location' => 'affiliate-menu',
		'menu_class' => 'nav nav-pills',
		'walker' => new WP_Bootstrap_Navwalker(),
));

/*
// API-URL 
$api_url = 'https://api.clevermatch.com/recommendations';

// API-Request mit Caching (Transient für 15 Minuten)
$transient_key = 'cm_recommendations_' . md5($api_url);
$data = get_transient($transient_key);

if (false === $data) {
		$response = wp_remote_get($api_url, [
				'headers' => [
						'Authorization' => 'Bearer ' . get_option('cm_api_key'), // API-Key aus Plugin-Optionen
						'Accept' => 'application/json'
				],
				'timeout' => 10,
				'ssl_verify' => true // Nur im Live-Betrieb aktivieren
		]);

		if (!is_wp_error($response) && 200 === wp_remote_retrieve_response_code($response)) {
				$data = json_decode(wp_remote_retrieve_body($response), true);
				set_transient($transient_key, $data, 15 * MINUTE_IN_SECONDS);
		}
}

// Fehlerbehandlung
if (empty($data) || !is_array($data)) {
		echo '<div class="alert alert-danger">Daten konnten nicht geladen werden.</div>';
		get_footer();
		return;
}
*/

?>

<?php
// Dummy-Daten Empfehlungen
$dummy_data = [
		[
				'type' => 'Unternehmen',
				'name' => 'Tech Corp GmbH',
				'provision' => '4500',
				'status' => 'Angenommen',
				'payout' => 'Konto fehlt'
		],
		[
				'type' => 'Unternehmen',
				'name' => 'Mittelstands GmbH & Co. KG',
				'provision' => '5000',
				'status' => 'Angebot versendet',
				'payout' => 'Ausstehend'
		],
		[
				'type' => 'Unternehmen',
				'name' => 'Müller & Partner',
				'provision' => '3500',
				'status' => 'Im Prozess',
				'payout' => ''
		],
		[
				'type' => 'Unternehmen',
				'name' => 'Müller & Partner',
				'provision' => '4500',
				'status' => 'Angenommen',
				'payout' => 'Ausgezahlt'
		],
		[
				'type' => 'Kandidat',
				'name' => 'T. S.',
				'provision' => '3500',
				'status' => 'Im Prozess',
				'payout' => ''
		],
		[
				'type' => 'Kandidat',
				'name' => 'B. B.',
				'provision' => '4000',
				'status' => 'Angebot versendet',
				'payout' => 'Ausstehend'
		],						
		[
				'type' => 'Kandidat',
				'name' => 'W. N.',
				'provision' => '3000',
				'status' => 'Angenommen',
				'payout' => 'Ausgezahlt'
		]
];
?>

<h1>Willkommen beim CleverMatch Empfehlungsprogramm.</h1>

<!-- Bereich: Aktuelle Empfehlungen -->

<h3>Ihre aktuellen Empfehlungen</h3>

<div class="card cm-card mb-4">
	<div class="card-body">

		<table class="table">
			<!-- Desktop-Überschriften -->
			<thead>
				<tr>
					<th class="col-md-2 col-lg-2">Typ</th>
					<th class="col-md-4 col-lg-4">Name/Firma</th>
					<th class="col-md-2 col-lg-2">Provision</th>
					<th class="col-md-3 col-lg-2">Status</th>
					<th class="col-md-1 col-lg-2">Auszahlung</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($dummy_data as $item): ?>
				<tr>
					<!-- Desktop-Zellen -->
					<td class="d-none d-md-table-cell col-md-3 col-lg-2"><?= esc_html($item['type']) ?></td>
					<td class="d-none d-md-table-cell col-md-4 col-lg-4"><?= esc_html($item['name']) ?></td>
					<td class="d-none d-md-table-cell col-md-2 col-lg-2"><?= number_format($item['provision'], 0, ',', '.') ?> €</td>
					<td class="d-none d-md-table-cell col-md-3 col-lg-2"><?= esc_html($item['status']) ?></td>
					<td class="d-none d-md-table-cell col-md-1 col-lg-2"><?= esc_html($item['payout']) ?></td>

					<!-- Mobile-Zelle (komplette Karte) -->
					<td class="d-md-none">
						<div class="mobile-card p-3">
							<div class="row">
								<div class="col-4 fw-bolder blue">Typ:</div>
								<div class="col-8"><?= esc_html($item['type']) ?></div>
							</div>
							<div class="row mt-2">
								<div class="col-4 fw-bolder blue">Name/Firma:</div>
								<div class="col-8"><?= esc_html($item['name']) ?></div>
							</div>
							<div class="row mt-2">
								<div class="col-4 fw-bolder blue">Provision:</div>
								<div class="col-8"><?= number_format($item['provision'], 0, ',', '.') ?> €</div>
							</div>
							<div class="row mt-2">
								<div class="col-4 fw-bolder blue">Status:</div>
								<div class="col-8"><?= esc_html($item['status']) ?></div>
							</div>
							<div class="row mt-2">
								<div class="col-4 fw-bolder blue">Auszahlung:</div>
								<div class="col-8"><?= esc_html($item['payout']) ?></div>
							</div>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

	</div>
</div>


<!-- Cards mit Erfolgen -->
<div class="row mb-2">
		<!-- Dummy-Content (später durch API ersetzen) -->
		<?php 
		$success_cards = [
				['title' => 'Empfohlene Kandidaten', 'value' => 12],
				['title' => 'Empfohlene Unternehmen', 'value' => 8],
				['title' => 'Erfolgreiche Platzierungen', 'value' => 5]
		];
		foreach ($success_cards as $success): ?>
		<div class="col-md-4 mb-3">
				<div class="card cm-card h-100 text-center">
						<p class="mb-2"><?= esc_html($success['title']) ?></p>
						<h4 class="mb-0"><?= esc_html($success['value']) ?></h4>
				</div>
		</div>
		<?php endforeach; ?>
</div>


<!-- Cards mit Provisionen -->
		<div class="row mb-5">
		<!-- Dummy-Content (später durch API ersetzen) -->
		<?php 
		$provision_cards = [
				['title' => 'Ausstehende Provisionen', 'value' => 7500, 'type' => 'amount'],
				['title' => 'Verdiente Provisionen', 'value' => 2000, 'type' => 'amount']
		];		
		foreach ($provision_cards as $card): ?>
		<div class="col-md-6 mb-3">
				<div class="card cm-card h-100">
						<div class="card-body text-center">
								<p class="mb-2"><?= esc_html($card['title']) ?></p>
								<h4 class="mb-0"><?= number_format($card['value'], 0, ',', '.') ?> €</h4>
						</div>
				</div>
		</div>
		<?php endforeach; ?>
</div>


<!-- Bereich: Ihr Empfehlungslink -->
<h3>Ihr Empfehlungslink für Kandidaten</h3>

<div class="card cm-card h-100 text-center">
		<!-- Dummy-Link (später durch API ersetzen) -->
		<?php $reco_link = 'https://www.clevermatch.com/jobs/?afid=ABC12345'; ?>
		<a class="link-dark p-3" href="<?= esc_url($reco_link) ?>" target="_blank">
				<strong><?= esc_html($reco_link) ?></strong>
		</a>
</div>

<?php
get_footer();