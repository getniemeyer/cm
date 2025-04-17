<?php
/**
 * Formular für Unternehmensempfehlungen im clevermatch-jobs Plugin
 */
?>
<div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2 m-auto">

<p class="mb-5">Sie bekommen mit, dass&nbsp;ein Arbeitgeber&nbsp;Mitarbeiter sucht?&nbsp;Empfehlen Sie&nbsp;ihn&nbsp;uns hier – wir kümmern uns um alles Weitere.&nbsp;Für jede erfolgreiche Empfehlung erhalten Sie eine attraktive Provision!</p>

<div class="card cm-card mb-4">
	<div class="card-body">

		<div class="form-empfehlung">
			<h4 class="mb-3">Unternehmen empfehlen</h4>

			<form id="empfehlungsForm" class="row g-3 needs-validation" novalidate>
				<input id="afpID" name="afpID" type="hidden" value="<?php echo esc_attr($_COOKIE['afpid'] ?? ''); ?>">

				<div class="col-12">
					<label for="CompanyName" class="form-label">Name des Unternehmens</label>
					<input type="text" class="form-control" id="CompanyName" aria-label="CompanyName" required>
					<div class="invalid-feedback">
						Bitte geben Sie das Unternehmen an.
					</div>
				</div>

				<div class="col-lg-6">
					<label for="Address1" class="form-label">Adresse 1 (optional)</label>
					<input type="text" class="form-control" id="Address1" aria-label="Address1">
				</div>
				<div class="col-lg-6">
					<label for="Address2" class="form-label">Adresse 2 (optional)</label>
					<input type="text" class="form-control" id="Address2" aria-label="Address2">
				</div>

				<div class="col-lg-2">
					<label for="PostalCode" class="form-label">PLZ (optional)</label>
					<input type="text" class="form-control" id="PostalCode" aria-label="PostalCode">
				</div>
				<div class="col-lg-4">
					<label for="City" class="form-label">Ort (optional)</label>
					<input type="text" class="form-control" id="City" aria-label="City">
				</div>
				<div class="col-lg-6">
					<label for="Country" class="form-label">Land</label>
					<select class="form-select" aria-label="Country">
						<option value="DE" selected>Deutschland</option>
						<option value="AT">Österreich</option>
						<option value="CH">Schweiz</option>
						<hr>
						<option value="AF">Afghanistan</option>
						<option value="EG">Ägypten</option>
						<option value="AD">Andorra</option>
						<option value="AL">Albanien</option>
						<option value="DZ">Algerien</option>
						<option value="AS">Amerikanisch-Samoa</option>
						<option value="VI">Amerikanische Jungferninseln</option>
						<option value="AG">Antigua und Barbuda</option>
						<option value="AI">Anguilla</option>
						<option value="AO">Angola</option>
						<option value="AQ">Antarktika</option>
						<option value="GQ">Äquatorialguinea</option>
						<option value="AR">Argentinien</option>
						<option value="AM">Armenien</option>
						<option value="AW">Aruba</option>
						<option value="ET">Äthiopien</option>
						<option value="AX">Åland</option>
						<option value="AZ">Aserbaidschan</option>
						<option value="AU">Australien</option>
						<option value="BS">Bahamas</option>
						<option value="BH">Bahrain</option>
						<option value="BD">Bangladesch</option>
						<option value="BB">Barbados</option>
						<option value="BY">Belarus</option>
						<option value="BZ">Belize</option>
						<option value="BE">Belgien</option>
						<option value="BJ">Benin</option>
						<option value="BM">Bermuda</option>
						<option value="BT">Bhutan</option>
						<option value="BO">Bolivien</option>
						<option value="BQ">Bonaire, Sint Eustatius und Saba</option>
						<option value="BA">Bosnien und Herzegowina</option>
						<option value="BW">Botsuana</option>
						<option value="BV">Bouvetinsel</option>
						<option value="BF">Burkina Faso</option>
						<option value="BR">Brasilien</option>
						<option value="VG">Britische Jungferninseln</option>
						<option value="BN">Brunei</option>
						<option value="BG">Bulgarien</option>
						<option value="BI">Burundi</option>
						<option value="CL">Chile</option>
						<option value="CN">China</option>
						<option value="CK">Cookinseln</option>
						<option value="CR">Costa Rica</option>
						<option value="CW">Curaçao</option>
						<option value="DK">Dänemark</option>
						<option value="CD">Demokratische Republik Kongo</option>
						<option value="DM">Dominica</option>
						<option value="DO">Dominikanische Republik</option>
						<option value="DJ">Dschibuti</option>
						<option value="EC">Ecuador</option>
						<option value="CI">Elfenbeinküste</option>
						<option value="SV">El Salvador</option>
						<option value="ER">Eritrea</option>
						<option value="EE">Estland</option>
						<option value="SZ">Eswatini</option>
						<option value="FK">Falklandinseln</option>
						<option value="FO">Färöer</option>
						<option value="FJ">Fidschi</option>
						<option value="FI">Finnland</option>
						<option value="FR">Frankreich</option>
						<option value="GF">Französisch-Guayana</option>
						<option value="PF">Französisch-Polynesien</option>
						<option value="TF">Französische Süd- und Antarktisgebiete</option>
						<option value="GA">Gabun</option>
						<option value="GM">Gambia</option>
						<option value="GE">Georgien</option>
						<option value="GH">Ghana</option>
						<option value="GI">Gibraltar</option>
						<option value="GD">Grenada</option>
						<option value="GR">Griechenland</option>
						<option value="GL">Grönland</option>
						<option value="GP">Guadeloupe</option>
						<option value="GU">Guam</option>
						<option value="GW">Guinea-Bissau</option>
						<option value="GY">Guyana</option>
						<option value="GT">Guatemala</option>
						<option value="GG">Guernsey</option>
						<option value="GN">Guinea</option>
						<option value="HT">Haiti</option>
						<option value="HM">Heard und McDonaldinseln</option>
						<option value="HK">Hongkong</option>
						<option value="HN">Honduras</option>
						<option value="IN">Indien</option>
						<option value="ID">Indonesien</option>
						<option value="IQ">Irak</option>
						<option value="IR">Iran</option>
						<option value="IE">Irland</option>
						<option value="IS">Island</option>
						<option value="IL">Israel</option>
						<option value="IM">Isle of Man</option>
						<option value="IT">Italien</option>
						<option value="JE">Jersey</option>
						<option value="JM">Jamaika</option>
						<option value="JO">Jordanien</option>
						<option value="JP">Japan</option>
						<option value="YE">Jemen</option>
						<option value="KY">Kaimaninseln</option>
						<option value="KH">Kambodscha</option>
						<option value="CM">Kamerun</option>
						<option value="CA">Kanada</option>
						<option value="CV">Kap Verde</option>
						<option value="KZ">Kasachstan</option>
						<option value="QA">Katar</option>
						<option value="KE">Kenia</option>
						<option value="KG">Kirgisistan</option>
						<option value="KI">Kiribati</option>
						<option value="CC">Kokosinseln</option>
						<option value="CO">Kolumbien</option>
						<option value="KM">Komoren</option>
						<option value="CG">Republik Kongo</option>
						<option value="HR">Kroatien</option>
						<option value="CU">Kuba</option>
						<option value="KW">Kuwait</option>
						<option value="LA">Laos</option>
						<option value="LB">Libanon</option>
						<option value="LR">Liberia</option>
						<option value="LY">Libyen</option>
						<option value="LI">Liechtenstein</option>
						<option value="LT">Litauen</option>
						<option value="LS">Lesotho</option>
						<option value="LV">Lettland</option>
						<option value="LU">Luxemburg</option>
						<option value="LC">Saint Lucia</option>
						<option value="MO">Macao</option>
						<option value="MG">Madagaskar</option>
						<option value="MW">Malawi</option>
						<option value="MY">Malaysia</option>
						<option value="MV">Malediven</option>
						<option value="ML">Mali</option>
						<option value="MT">Malta</option>
						<option value="MA">Marokko</option>
						<option value="MH">Marshallinseln</option>
						<option value="MQ">Martinique</option>
						<option value="MR">Mauretanien</option>
						<option value="MU">Mauritius</option>
						<option value="YT">Mayotte</option>
						<option value="MX">Mexiko</option>
						<option value="FM">Mikronesien</option>
						<option value="MD">Moldau</option>
						<option value="MC">Monaco</option>
						<option value="MN">Mongolei</option>
						<option value="ME">Montenegro</option>
						<option value="MS">Montserrat</option>
						<option value="MZ">Mosambik</option>
						<option value="MM">Myanmar</option>
						<option value="NA">Namibia</option>
						<option value="NR">Nauru</option>
						<option value="NP">Nepal</option>
						<option value="NC">Neukaledonien</option>
						<option value="NZ">Neuseeland</option>
						<option value="NI">Nicaragua</option>
						<option value="NL">Niederlande</option>
						<option value="NE">Niger</option>
						<option value="NG">Nigeria</option>
						<option value="NU">Niue</option>
						<option value="KP">Nordkorea</option>
						<option value="MP">Nördliche Marianen</option>
						<option value="MK">Nordmazedonien</option>
						<option value="NF">Norfolkinsel</option>
						<option value="NO">Norwegen</option>
						<option value="OM">Oman</option>
						<option value="TL">Osttimor</option>
						<option value="PW">Palau</option>
						<option value="PA">Panama</option>
						<option value="PY">Paraguay</option>
						<option value="PE">Peru</option>
						<option value="PK">Pakistan</option>
						<option value="PS">Palästinensische Autonomiegebiete</option>
						<option value="PG">Papua-Neuguinea</option>
						<option value="PH">Philippinen</option>
						<option value="PN">Pitcairninseln</option>
						<option value="PL">Polen</option>
						<option value="PT">Portugal</option>
						<option value="PR">Puerto Rico</option>
						<option value="RE">Réunion</option>
						<option value="RW">Ruanda</option>
						<option value="RO">Rumänien</option>
						<option value="RU">Russland</option>
						<option value="BL">Saint-Barthélemy</option>
						<option value="KN">Saint Kitts und Nevis</option>
						<option value="MF">Saint-Martin</option>
						<option value="PM">Saint-Pierre und Miquelon</option>
						<option value="VC">Saint Vincent und die Grenadinen</option>
						<option value="SH">St. Helena, Ascension und Tristan da Cunha</option>
						<option value="SB">Salomonen</option>
						<option value="ZM">Sambia</option>
						<option value="WS">Samoa</option>
						<option value="SM">San Marino</option>
						<option value="ST">São Tomé und Principe</option>
						<option value="SA">Saudi-Arabien</option>
						<option value="SE">Schweden</option>
						<option value="SN">Senegal</option>
						<option value="RS">Serbien</option>
						<option value="SC">Seychellen</option>
						<option value="ZW">Simbabwe</option>
						<option value="SG">Singapur</option>
						<option value="SX">Sint Maarten</option>
						<option value="SK">Slowakei</option>
						<option value="SI">Slowenien</option>
						<option value="SL">Sierra Leone</option>
						<option value="SO">Somalia</option>
						<option value="ES">Spanien</option>
						<option value="LK">Sri Lanka</option>
						<option value="SD">Sudan</option>
						<option value="SR">Surinam</option>
						<option value="ZA">Südafrika</option>
						<option value="GS">Südgeorgien und die Südlichen Sandwichinseln</option>
						<option value="KR">Südkorea</option>
						<option value="SS">Südsudan</option>
						<option value="SJ">Svalbard und Jan Mayen</option>
						<option value="SY">Syrien</option>
						<option value="TJ">Tadschikistan</option>
						<option value="TW">Taiwan</option>
						<option value="TZ">Tansania</option>
						<option value="TH">Thailand</option>
						<option value="TG">Togo</option>
						<option value="TK">Tokelau</option>
						<option value="TO">Tonga</option>
						<option value="TT">Trinidad und Tobago</option>
						<option value="CZ">Tschechien</option>
						<option value="TD">Tschad</option>
						<option value="TN">Tunesien</option>
						<option value="TM">Turkmenistan</option>
						<option value="TC">Turks- und Caicosinseln</option>
						<option value="TR">Türkei</option>
						<option value="TV">Tuvalu</option>
						<option value="UG">Uganda</option>
						<option value="UA">Ukraine</option>
						<option value="HU">Ungarn</option>
						<option value="UM">United States Minor Outlying Islands</option>
						<option value="UY">Uruguay</option>
						<option value="UZ">Usbekistan</option>
						<option value="VU">Vanuatu</option>
						<option value="VA">Vatikanstadt</option>
						<option value="VE">Venezuela</option>
						<option value="AE">Vereinigte Arabische Emirate</option>
						<option value="US">Vereinigte Staaten</option>
						<option value="GB">Vereinigtes Königreich</option>
						<option value="VN">Vietnam</option>
						<option value="WF">Wallis und Futuna</option>
						<option value="CX">Weihnachtsinsel</option>
						<option value="EH">Westsahara</option>
						<option value="CF">Zentralafrikanische Republik</option>
						<option value="CY">Zypern</option>
					</select>
				</div>

				<h4 class="mt-5 mb-2">Ansprechpartner</h4>

				<div class="col-lg-6">
					<label for="Anrede" class="col-form-label small">Anrede</label><br>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="flexRadioDefault" id="radio1" required>
						<label class="form-check-label me-2" for="radio1">
							Frau
						</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="flexRadioDefault" id="radio2" required>
						<label class="form-check-label" for="radio2">
							Herr
						</label>
						<div class="invalid-feedback">
							Bitte geben Sie eine Anrede an.
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<label for="Title" class="form-label">Titel</label>
					<input type="text" class="form-control" id="Title" aria-label="Title">
				</div>

				<div class="col-lg-6">
					<label for="FirstName" class="form-label">Vorname</label>
					<input type="text" class="form-control" id="FirstName" aria-label="FirstName" required>
					<div class="invalid-feedback">
						Bitte geben Sie den Vornamen an.
					</div>
				</div>
				<div class="col-lg-6">
					<label for="LastName" class="form-label">Nachname</label>
					<input type="text" class="form-control" id="LastName" aria-label="LastName" required>
					<div class="invalid-feedback">
						Bitte geben Sie den Nachnamen an.
					</div>
				</div>

				<div class="col-lg-6 mb-4">
					<label for="PhoneNumberOffice" class="form-label">Telefonnummer (optional)</label>
					<input type="text" class="form-control" id="PhoneNumberOffice" aria-label="PhoneNumberOffice">
				</div>
				<div class="col-lg-6 mb-4">
					<label for="Email" class="form-label">E-Mail (optional)</label>
					<input type="email" class="form-control" id="Email" aria-label="Email">
				</div>


				<div class="col-lg-6 mb-4">
					<label for="Textarea" class="form-label">Anmerkungen (optional)</label>
					<textarea type="text" class="form-control rounded-4" id="Textarea" aria-label="Notes" rows="3"></textarea>
				</div>

				<div class="col-lg-6 mb-4">
					<label for="Partner" class="form-label">Zuständiger Partner (optional)</label>
					<select class="form-select" aria-label="Partner">
						<option value="ZE" selected>Zentrale wählt aus</option>
						<option value="AO">Anja Odenthal</option>
						<option value="AP">Ann-Kathrin Piwellek</option>
						<option value="CP">Christine Prütz</option>
						<option value="CL">Dr. Carsten Lüthgens</option>
						<option value="GJ">Gabriela Jaecker</option>
						<option value="HJ">Hans-Uwe Jaeger</option>
						<option value="JS">Jessica Schramböhmer</option>
						<option value="MS">Michael Schaffer</option>
						<option value="OS">Oskar Stolte</option>
						<option value="TW">Thomas Wilm</option>
					</select>
				</div>

				<div class="col-12">
					<div class="form-check custom-control custom-checkbox pb-1">
						<input class="form-check-input custom-control-input me-2" id="DoNotDiscloseReferrer" name="DoNotDiscloseReferrer" type="checkbox" value="true"><input name="DoNotDiscloseReferrer" type="hidden" value="false">
						<label class="form-check-label custom-control-label" for="DoNotDiscloseReferrer">Ich möchte nicht als Empfehlungspartner genannt werden</label>
					</div>
				</div>
				<div class="col-8 col-lg-6">
					<button class="btn btn-info mt-4" type="submit">Empfehlung senden <i class="fas fa-long-arrow-right"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>