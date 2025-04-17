<div class="cm--candidates">
    <div class="cm--filter rounded-3">
        <form id="cmSearchForm" class="row g-4 mb-2 py-3 px-3 p-lg-4 pb-3 pb-lg-5 d-flex align-items-end">
            <div class="col-12 col-lg-3">
                <label for="industry" class="form-label">Branche</label>
                <input type="text" class="form-control rounded-3" name="industry" id="industry" minlength="2" maxlength="60" tabindex="1">
            </div>
            <div class="col-12 col-lg-3">
                <label for="location" class="form-label">Einsatzort (z.B. Stadt)</label>
                <input type="text" class="form-control rounded-3" name="location" id="location" minlength="2" maxlength="60" tabindex="2">
            </div>
            <div class="col-12 col-lg-3">
                <label for="keyword" class="form-label">Suchbegriff</label>
                <input type="text" class="form-control rounded-3" name="keyword" id="keyword" minlength="2" maxlength="100" tabindex="3">
            </div>
            <div class="col-12 col-lg-3 mb-1 btn-candidate-search">
                <button type="submit" class="btn btn-info" id="filterSubmit" tabindex="4">Kandidaten finden</button>
            </div>
        </form>

        <?php include "mobile-template.php" ?>

    </div>

    <div class="row">
        <div class="col-sm-12 col-lg-4 col-xl-3 filter-lg">
            <h4>Filter</h4>
            <form id="cmFilterForm" method="post" enctype="x-www-form-urlencoded">

                <div class="accordion cm-accordion" id="cmFilter">
                    <div class="accordion-item rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterBerufsfeld" aria-expanded="false" aria-controls="filterBerufsfeld">Berufsfeld
                                <span class="cm-filter-count badge rounded-pill" style="display:none">0</span>
                            </button>
                        </h2>

                        <div id="filterBerufsfeld" class="accordion-collapse collapse">
                            <div class="accordion-body">

                                <div class="form-check">
                                    <label class="form-check-label" for="allFieldOfWork"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="" id="allFieldOfWork">Alle</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label " for="allgemein"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="14" id="allgemein">Allgemein</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="einkauf"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="3" id="einkauf">Einkauf</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="finanzen"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="2" id="finanzen">Finanzen/Recht/Audit</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="it"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="5" id="it">IT/Digitalisierung</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="logistik"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="6" id="logistik">Logistik</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="marketing"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="7" id="marketing">Marketing/PR</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="personal"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="8" id="personal">Personal</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="produktion"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="9" id="produktion">Produktion/Operations</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="technik"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="4" id="technik">Technik/Entwicklung</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="vertrieb"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="10" id="vertrieb">Vertrieb</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="accordion-item rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterEbene" aria-expanded="false" aria-controls="filterEbene">Ebene
                                <span class="cm-filter-count badge rounded-pill" style="display:none">0</span>
                            </button>
                        </h2>
                        <div id="filterEbene" class="accordion-collapse collapse">
                            <div class="accordion-body">

                                <div class="form-check">
                                    <label class="form-check-label" for="allSeniority"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="" id="allSeniority">Alle</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="gf"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="11" id="gf">Geschäftsführung/Vorstand</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="fuk"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="10" id="fuk">Führungskraft</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="fak"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="6" id="fak">Fachkraft</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="hab"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="7" id="hab">Hochschulabsolvent</label>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="accordion-item rounded-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button rounded-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filterGehalt" aria-expanded="false" aria-controls="filterGehalt">Jahresgehalt
                                <span class="cm-filter-count badge rounded-pill" style="display:none">0</span>
                            </button>
                        </h2>
                        <div id="filterGehalt" class="accordion-collapse collapse">
                            <div class="accordion-body">

                                <input type="hidden" name="salary_min" id="salary_min" value="0">
                                <input type="hidden" name="salary_max" id="salary_max" value="9999999">

                                <div class="form-check">
                                    <label class="form-check-label" for="allSalaryRanges"><input class="form-check-input salary-range" data-min="0" data-max="9999999" type="checkbox" name="salary" value="9999999" id="allSalaryRanges">Alle</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-1"><input class="form-check-input salary-range" data-min="40000" data-max="60000" type="checkbox" name="salary" value="40000" id="salary-range-1">40.000 - 60.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-2"><input class="form-check-input salary-range" data-min="60001" data-max="80000" type="checkbox" name="salary" value="60001" id="salary-range-2">60.001 - 80.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-3"><input class="form-check-input salary-range" data-min="80001" data-max="100000" type="checkbox" name="salary" id="salary-range-3">80.001 - 100.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-4"><input class="form-check-input salary-range" data-min="100001" data-max="120000" type="checkbox" name="salary" value="100001" id="salary-range-4">100.001 - 120.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-5"><input class="form-check-input salary-range" data-min="120001" data-max="150000" type="checkbox" name="salary" value="120001" id="salary-range-5">120.001 - 140.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-6"><input class="form-check-input salary-range" data-min="140001" data-max="160000" type="checkbox" name="salary" value="140001" id="salary-range-6">140.001 - 160.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-7"><input class="form-check-input salary-range" data-min="160001" data-max="180000" type="checkbox" name="salary" value="160001" id="salary-range-7">160.001 - 180.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-8"><input class="form-check-input salary-range" data-min="180001" data-max="200000" type="checkbox" name="salary" value="180001" id="salary-range-8">180.001 - 200.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-9"><input class="form-check-input salary-range" data-min="200001" data-max="250000" type="checkbox" name="salary" value="200001" id="salary-range-9">200.001 - 250.000 €</label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="salary-range-10"><input class="form-check-input salary-range" data-min="250001" data-max="9999999" type="checkbox" name="salary" value="250001" id="salary-range-10">> 250.000 €</label>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="cm-filter-reset">
                <button type="button" id="cmFilterReset" class="btn btn-sm btn-outline-info mt-2">Alle Filter zurücksetzen</button>
            </div>

            <div class="cm-find-link-lg mt-5">
                <h4>Keinen Kandidaten gefunden?</h4>
                <a class="btn btn-sm btn-info" role="button" href="https://www.clevermatch.com/unternehmen/personal-anfragen/">Personal anfragen </a>
            </div>

            <?php
              $shortcode = '[clevermatch_iframe type="candidatealert"]';
              echo do_shortcode($shortcode); 
            ?>
        </div>

        <div class="col-sm-12 col-lg-8 col-xl-9 candidates" id="candidates">
            <div id="loadingSpinner" class="d-flex align-items-start justify-content-center d-none">
                <div class="spinner-border mt-5" role="status">
                    <span class="visually-hidden">Lädt...</span>
                </div>
            </div>
            <div id="cmCandidatesContainer"></div>
            <div class="cm-find-link-sm">
                <h4>Keinen Kandidaten gefunden?</h4>
                <a class="btn btn-info" role="button" href="https://www.clevermatch.com/unternehmen/personal-anfragen/">Personal anfragen <i class="fas fa-long-arrow-right"></i></a>
                <?php
                  $shortcode = '[clevermatch_iframe type="candidatealert"]';
                  echo do_shortcode($shortcode); 
                ?>
            </div>
        </div>
    </div>
</div>