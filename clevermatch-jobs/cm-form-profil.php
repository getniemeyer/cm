<?php
/**
 * Formular für Empfehler-Profil im clevermatch-jobs Plugin
 */
?>
<div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2 m-auto">

<div class="card cm-card mb-4">
	<div class="card-body">

		<div class="form-profil">

			<form id="profilForm" method="POST">
				<div class="row">

				<input id="afpID" name="afpID" type="hidden" value="<?php echo esc_attr($_COOKIE['afpid'] ?? ''); ?>">

					<div class="col-md-6 mb-2">
						<label for="radio" class="col-form-label">Anrede</label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="flexRadioDefault" id="radio1">
							<label class="form-check-label me-3" for="radio1">Frau</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="flexRadioDefault" id="radio2">
							<label class="form-check-label" for="radio2">Herr</label>
						</div>
					</div>


					<div class="col-md-6">
						<label for="Title" class="form-label">Titel</label>
						<input type="text" class="form-control" id="Title" name="title">
					</div>

					<div class="col-md-6 mb-2">
						<label for="FirstName" class="form-label">Vorname</label>
						<input type="text" class="form-control" id="FirstName" name="first_name">
					</div>

					<div class="col-md-6 mb-2">
						<label for="LastName" class="form-label">Nachname</label>
						<input type="text" class="form-control" id="LastName" name="last_name">
					</div>

					<div class="col-md-6 mb-2">
						<label for="Email" class="form-label">E-Mail</label>
						<input type="email" class="form-control" id="Email" name="email">
					</div>

					<div class="col-md-6 mb-2">
						<label for="PhoneNumberOffice" class="form-label">Telefonnummer</label>
						<input type="text" class="form-control" id="PhoneNumberOffice" name="phone_number">
					</div>

					<div class="col-md-6 mb-3">
						<label for="CompanyName" class="form-label">Firmenname (optional)</label>
						<input type="text" class="form-control" id="CompanyName" name="company_name">
					</div>

					<h3 class="mt-3">Kontoinformation für die Anweisung Ihrer Provisionen</h3>

					<div class="col-md-6 mb-2">
						<label for="AccountHolder" class="form-label">Kontoinhaber</label>
						<input type="text" class="form-control" id="AccountHolder" name="account_holder">
					</div>

					<div class="col-md-6 mb-2">
						<label for="Bank" class="form-label">Bank</label>
						<input type="text" class="form-control" id="Bank" name="bank">
					</div>

					<div class="col-md-6 mb-2">
						<label for="IBAN" class="form-label">IBAN</label>
						<input type="text" class="form-control" id="IBAN" name="iban">
					</div>

					<div class="col-md-6 mb-2">
						<label for="BIC" class="form-label">BIC</label>
						<input type="text" class="form-control" id="BIC" name="bic">
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 mb-2">
						<button class="btn btn-info mt-4" type="submit">Profil aktualisieren <i class="fas fa-long-arrow-right"></i></button>
					</div>
				</div>
				<div class="alert mt-2" id="success-message" style="display: none;">Profil erfolgreich aktualisiert!</div>
			</form>

		</div>
	</div>
</div>

</div>