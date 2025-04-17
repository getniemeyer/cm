jQuery(document).ready(function($) {
		$('#profilForm').submit(function(event) {
				event.preventDefault();
				var formData = {
						'action': 'profil_aktualisieren',
						'afpid': $('#afpid').val(),
						'AffiliateId': $('#AffiliateId').val(),
						'Anrede': $('#Anrede').val(),
						'Titel': $('#Titel').val(),
						'Vorname': $('#Vorname').val(),
						'Nachname': $('#Nachname').val(),
						'Email': $('#Email').val(),
						'PhoneNumberOffice': $('#PhoneNumberOffice').val(),
						'CompanyName': $('#CompanyName').val()
				};

				$.ajax({
						type: 'POST',
						url: ajax_object.ajax_url,
						data: formData,
						success: function(data) {
								if (data.success) {
										alert('Profil erfolgreich aktualisiert!');
								} else {
										$.each(data.errors, function(field, message) {
												$('#' + field).after('<span class="error">' + message + '</span>');
										});
								}
						},
						error: function(xhr, status, error) {
								console.error('Ajax-Fehler:', error);
						}
				});
		});
});
