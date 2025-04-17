<!-- Mobile Button  -->
<div class="row filter-btn rounded-bottom-3 g-0 px-3 pt-0 pb-0">
    <div class="col-12 col-lg-3 ">
        <button class="btn btn-info mb-3" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
            <svg id="filterBtn" xmlns="http://www.w3.org/2000/svg" height="17" width="17" viewBox="0 0 150 123.21" fill="#ffffff">
                <path class="cls-1" d="M88.39,107.14h-26.79c-4.42,0-8.04,3.62-8.04,8.04h0c0,4.42,3.62,8.04,8.04,8.04h26.79c4.42,0,8.04-3.62,8.04-8.04h0c0-4.42-3.62-8.04-8.04-8.04ZM141.96,0H8.04C3.62,0,0,3.62,0,8.04h0c0,4.42,3.62,8.04,8.04,8.04h133.93c4.42,0,8.04-3.62,8.04-8.04h0c0-4.42-3.62-8.04-8.04-8.04ZM120.54,53.57H29.46c-4.42,0-8.04,3.62-8.04,8.04h0c0,4.42,3.62,8.04,8.04,8.04h91.07c4.42,0,8.04-3.62,8.04-8.04h0c0-4.42-3.62-8.04-8.04-8.04Z" />
            </svg>Weitere Filter
        </button>
        
        <button type="button" id="cmFilterModalReset" class="btn btn-sm btn-outline-info btn-inline mb-3">Alle Filter zurücksetzen</button>
    </div>
</div>

<!-- Modal Start -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="filterModalLabel">Weitere Filter</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="cmFilterModal" method="post" enctype="x-www-form-urlencoded">

                    <div class="filter filter-sm mb-4">
                        <h4 class="mb-2">Berufsfeld</h4>
                        <div class="form-check">
                            <label class="form-check-label" for="allmFieldOfWork"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="" id="allmFieldOfWork">Alle</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="allgemeinM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="14" id="allgemeinM">Allgemein</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="einkaufM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="3" id="einkaufM">Einkauf</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="finanzenM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="2" id="finanzenM">Finanzen/Recht/Audit</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="itM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="5" id="itM">IT/Digitalisierung</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="logistikM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="6" id="logistikM">Logistik</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="marketingM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="7" id="marketingM">Marketing/PR</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="personalM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="8" id="personalM">Personal</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="produktionM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="9" id="produktionM">Produktion/Operations</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="technikM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="4" id="technikM">Technik/Entwicklung</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="vertriebM"><input class="form-check-input fieldOfWork-checkbox" type="checkbox" name="fieldOfWork" value="10" id="vertriebM">Vertrieb</label>
                        </div>
                    </div>

                    <div class="filter filter-sm mb-4">
                        <h4 class="mb-2">Ebene</h4>
                        <div class="form-check">
                            <label class="form-check-label" for="allmSeniority"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="" id="allmSeniority">Alle</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="gfM"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="11" id="gfM">Geschäftsführung/Vorstand</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="fukM"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="10" id="fukM">Führungskraft</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="fakM"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="6" id="fakM">Fachkraft</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="habM"><input class="form-check-input seniority-checkbox" type="checkbox" name="seniority" value="7" id="habM">Hochschulabsolvent</label>
                        </div>
                    </div>


                    <div class="filter filter-sm mb-4">
                        <h4 class="mb-2">Jahresgehalt</h4>
                        <div class="form-check">
                            <label class="form-check-label" for="allmSalaryRanges"><input class="form-check-input salary-range" data-min="0" data-max="9999999" type="checkbox" name="salary" value="9999999" id="allmSalaryRanges">Alle</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m1"><input class="form-check-input salary-range" data-min="40000" data-max="60000" type="checkbox" name="salary" value="40000" id="salary-range-m1">40.000 - 60.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m2"><input class="form-check-input salary-range" data-min="60001" data-max="80000" type="checkbox" name="salary" value="60001" id="salary-range-m2">60.001 - 80.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m3"><input class="form-check-input salary-range" data-min="80001" data-max="100000" type="checkbox" name="salary"  id="salary-range-m3">80.001 - 100.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m4"><input class="form-check-input salary-range" data-min="100001" data-max="120000" type="checkbox" name="salary"  id="salary-range-m4">100.001 - 120.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m5"><input class="form-check-input salary-range" data-min="120001" data-max="150000" type="checkbox" name="salary" value="120001" id="salary-range-m5">120.001 - 140.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m6"><input class="form-check-input salary-range" data-min="140001" data-max="160000" type="checkbox" name="salary" value="140001" id="salary-range-m6">140.001 - 160.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m7"><input class="form-check-input salary-range" data-min="160001" data-max="180000" type="checkbox" name="salary" value="160001" id="salary-range-m7">160.001 - 180.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m8"><input class="form-check-input salary-range" data-min="180001" data-max="200000" type="checkbox" name="salary" value="180001" id="salary-range-m8">180.001 - 200.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m9"><input class="form-check-input salary-range" data-min="200001" data-max="250000" type="checkbox" name="salary" value="200001" id="salary-range-m9">200.001 - 250.000 €</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="salary-range-m10"><input class="form-check-input salary-range" data-min="250001" data-max="9999999" type="checkbox" name="salary" value="250001" id="salary-range-m10">> 250.000 €</label>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="filterModalApply">Kandidaten finden</button>
            </div>

        </div>
    </div>
</div> <!-- Modal End -->
