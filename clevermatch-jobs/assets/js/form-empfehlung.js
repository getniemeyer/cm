jQuery(document).ready(function($) {
		$('#empfehlungsForm').submit(function(event) {
				event.preventDefault();
				var formData = {
						'action': 'empfehlung_senden',
						'afpid': $('#afpid').val(),
						'AffiliateId': $('#AffiliateId').val(),
						'CompanyName': $('#CompanyName').val(),
						'Address1': $('#Address1').val(),
						'Address2': $('#Address2').val(),
						'PostalCode': $('#PostalCode').val(),
						'City': $('#City').val(),
						'Country': $('#Country').val(),
						'Anrede': $('input[name="flexRadioDefault"]:checked').val(),
						'Title': $('#Title').val(),
						'FirstName': $('#FirstName').val(),
						'LastName': $('#LastName').val(),
						'PhoneNumberOffice': $('#PhoneNumberOffice').val(),
						'Email': $('#Email').val(),
						'Notes': $('#Textarea').val(),
						'Partner': $('#Partner').val(),
						'DoNotDiscloseReferrer': $('#DoNotDiscloseReferrer').prop('checked')
				};

				$.ajax({
						type: 'POST',
						url: ajax_object.ajax_url,
						data: formData,
						success: function(data) {
								if (data.success) {
										alert('Empfehlung erfolgreich gesendet!');
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
