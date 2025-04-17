// AFID an URLs anhängen (nur für Empfänger-Links)
function appendAfidToUrl(url, afid) {
	if (url.includes('afid=')) return url;
	const separator = url.includes('?') ? '&' : '?';
	return `${url}${separator}afid=${encodeURIComponent(afid)}`;
}

// Modals für Affiliate-Buttons (Desktop & Mobile)
jQuery(document).ready(function($) {
	// Event-Listener für beide Button-Typen
	$('.affiliate-p-btn-desktop, .affiliate-p-btn-mobile').on('click', function(event) {
		event.preventDefault();

		// Modal-ID aus data-bs-target holen
		const modalId = $(this).attr('data-bs-target');

		// Modal-Konfiguration
		const modalElement = $(modalId);

		// Backdrop explizit entfernen
		modalElement.modal({
			backdrop: false // Deaktiviert den Backdrop
		});

		// Vorhandenen Backdrop löschen (falls vorhanden)
		$('.modal-backdrop').remove();

		// Modal anzeigen
		modalElement.modal('show');

		// AFID aus Cookie holen
		const afid = document.cookie.match(/afid=([^;]+)/)?.[1];

		// AFID an alle Links im Modal anhängen
		if (afid) {
			$(modalId).find('a').each(function() {
				const originalUrl = $(this).attr('href');
				if (originalUrl) {
					const separator = originalUrl.includes('?') ? '&' : '?';
					$(this).attr('href', `${originalUrl}${separator}afid=${encodeURIComponent(afid)}`);
				}
			});
		}
	});
});

// Client-seitige Fallback-Prüfung ob User eingeloggt ist
document.addEventListener('DOMContentLoaded', function() {
		// Deaktivierter API-Check (vorübergehend auskommentiert)
		/*
		fetch('https://jobs.clevermatch.com/api/check-auth', {
				credentials: 'include'
		})
		.then(response => {
				if (!response.ok) throw new Error('Network error');
				const contentType = response.headers.get('content-type');
				if (!contentType?.includes('application/json')) {
						throw new TypeError("Invalid JSON response");
				}
				return response.json();
		})
		.then(data => {
				if (!data.isLoggedIn && window.location.pathname.includes('/empfehlungsportal/')) {
						window.location.href = 'https://clevermatch.com/login?redirect=' + encodeURIComponent(window.location.href);
				}
		})
		.catch(error => {
				console.error('Auth check failed:', error);
		});
		*/
});
