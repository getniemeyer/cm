jQuery(document).ready(function($) {

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const savedFilters = sessionStorage.getItem('clevermatchFilters');

        if (savedFilters || urlParams.toString()) {
            let filters = {};

            if (savedFilters) {
                filters = JSON.parse(savedFilters);
            }

            // Fügen Sie URL-Parameter zu den Filtern hinzu
            for (const [key, value] of urlParams) {
                filters[key] = value;
            }

            Object.keys(filters).forEach(key => {
                const $elements = $(`[name="${key}"], [data-filter="${key}"]`);
                $elements.each(function() {
                    const $element = $(this);
                    if ($element.is(':checkbox')) {
                        // Für Checkboxen
                        const values = Array.isArray(filters[key]) ? filters[key] : filters[key].split(',');
                        $element.prop('checked', values.includes($element.val()));
                    } else if ($element.is('select')) {
                        // Für Select-Elemente
                        $element.val(filters[key]);
                        $element.trigger('change');
                    } else if ($element.hasClass('filter-badge')) {
                        // Für Filter-Badges
                        $element.addClass('active');
                    } else {
                        // Für andere Eingabefelder (text, number, etc.)
                        $element.val(filters[key]);
                    }
                });
            });

            // Aktualisieren Sie UI-Elemente, die von Checkboxen abhängen
            updateFilterCounts();
            updateFilterBadges();

            fetchCandidates(1, filters);

            // Entfernen Sie die Filter aus dem sessionStorage
            sessionStorage.removeItem('clevermatchFilters');

            // Bereinigen Sie die URL, ohne die Seite neu zu laden
            if (window.history && window.history.replaceState) {
                const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);
            }
        }
    });

    // Funktion zum Aktualisieren der Filter-Badges
    function updateFilterBadges() {
        $('.filter-badge').each(function() {
            const $badge = $(this);
            const filterKey = $badge.data('filter');
            const $checkbox = $(`input[name="${filterKey}"]:checked`);
            if ($checkbox.length > 0) {
                $badge.addClass('active');
            } else {
                $badge.removeClass('active');
            }
        });
    }

    // Funktion zum Serialisieren der Filter
    function serializeFilters() {
        const $forms = $('#cmSearchForm, #cmFilterForm, #cmFilterModal');
        let filterData = {};

        $forms.find('input:not([type="checkbox"]), select').each(function() {
            const name = $(this).attr('name');
            const value = $(this).val();
            if (name && value) {
                filterData[name] = value;
            }
        });

        // Behandeln von Checkboxen
        $forms.find('input[type="checkbox"]:checked').each(function() {
            const name = $(this).attr('name');
            if (!filterData[name]) {
                filterData[name] = [];
            }
            filterData[name].push($(this).val());
        });

        // Konvertieren von Arrays zu kommagetrennten Strings
        Object.keys(filterData).forEach(key => {
            if (Array.isArray(filterData[key])) {
                filterData[key] = filterData[key].join(',');
            }
        });

        return filterData;
    }


    const debounceDelay = 1300; // 1.3 Sekunden Verzögerung

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    const debouncedFetchCandidates = debounce(function() {
        showLoadingSpinner();
        fetchCandidates(1);
    }, debounceDelay);


    let isAllSalaryRangeSelected = false;
    let isAllSenioritySelected = false;
    let isAllFieldOfWorkSelected = false;

    function handleAllCheckbox(allCheckboxSelector, relatedCheckboxSelector) {
        const $allCheckbox = $(allCheckboxSelector);
        const $relatedCheckboxes = $(relatedCheckboxSelector);

        $allCheckbox.on('change', function() {
            const isChecked = $(this).prop('checked');
            $relatedCheckboxes.prop('checked', isChecked);

            if (allCheckboxSelector.includes('SalaryRanges')) {
                isAllSalaryRangeSelected = isChecked;
                updateSalaryRange();
            } else if (allCheckboxSelector.includes('Seniority')) {
                isAllSenioritySelected = isChecked;
            } else if (allCheckboxSelector.includes('FieldOfWork')) {
                isAllFieldOfWorkSelected = isChecked;
            }

            debouncedFetchCandidates();
        });

        $relatedCheckboxes.on('change', function() {
            const allChecked = $relatedCheckboxes.length === $relatedCheckboxes.filter(':checked').length;
            $allCheckbox.prop('checked', allChecked);

            if (allCheckboxSelector.includes('SalaryRanges')) {
                isAllSalaryRangeSelected = allChecked;
                updateSalaryRange();
            } else if (allCheckboxSelector.includes('Seniority')) {
                isAllSenioritySelected = allChecked;
            } else if (allCheckboxSelector.includes('FieldOfWork')) {
                isAllFieldOfWorkSelected = allChecked;
            }

            debouncedFetchCandidates();
        });
    }

    handleAllCheckbox('#allFieldOfWork', '.fieldOfWork-checkbox:not(#allFieldOfWork)');
    handleAllCheckbox('#allSeniority', '.seniority-checkbox:not(#allSeniority)');
    handleAllCheckbox('#allSalaryRanges', '.salary-range:not(#allSalaryRanges)');

    // Für Mobil
    handleAllCheckbox('#allmFieldOfWork', '.fieldOfWork-checkbox:not(#allmFieldOfWork)');
    handleAllCheckbox('#allmSeniority', '.seniority-checkbox:not(#allmSeniority)');
    handleAllCheckbox('#allmSalaryRanges', '.salary-range:not(#allmSalaryRanges)');


    function updateSalaryRange() {
        const checkedRanges = $('.salary-range:checked:not(#allSalaryRanges, #allmSalaryRanges)');
        const minSalary = isAllSalaryRangeSelected || !checkedRanges.length ? 0 : Math.min(...checkedRanges.map((_, el) => $(el).data('min')).get());
        const maxSalary = isAllSalaryRangeSelected || !checkedRanges.length ? 9999999 : Math.max(...checkedRanges.map((_, el) => $(el).data('max')).get());

        $('#salary_min').val(minSalary);
        $('#salary_max').val(maxSalary);
    }

    function showLoadingSpinner() {
        $('#loadingSpinner').removeClass('d-none');
        $('#candidates').children().not('#loadingSpinner').addClass('d-none');
    }

    function hideLoadingSpinner() {
        $('#loadingSpinner').addClass('d-none');
        $('#candidates').children().not('#loadingSpinner').removeClass('d-none');
    }

    function disableInputs() {
        $(":input").not(':button').attr("readonly", "readonly");
    }

    function enableInputs() {
        $(":input").not(':button').attr("readonly", null);
    }

    function updateFilterCounts() {
        $('.accordion-item').each(function() {
            const $accordionItem = $(this);
            const $button = $accordionItem.find('.accordion-button');
            const $collapse = $accordionItem.find('.accordion-collapse');
            const $countBadge = $button.find('.cm-filter-count');

            const checkedCount = $collapse.find('input[type="checkbox"]:checked').not('.all-checkbox').length;

            $countBadge.text(checkedCount);

            if (checkedCount > 0 && !$collapse.hasClass('show')) {
                $countBadge.show();
            } else {
                $countBadge.hide();
            }
        });
    }



    function fetchCandidates(page = 1) {
        disableInputs();
        showLoadingSpinner();

        isPaginating = (page !== 1);

        const $forms = $('#cmSearchForm, #cmFilterForm, #cmFilterModal');
        let formData = new URLSearchParams();

        // Sammle alle Formulardaten außer Checkboxen
        $forms.find('input:not([type="checkbox"]), select').each(function() {
            const name = $(this).attr('name');
            const value = $(this).val();
            if (name && value && name !== 'salary' && name !== 'salary_min' && name !== 'salary_max') {
                formData.append(name, value);
            }
        });

        // Behandle Field of Work
        const fieldOfWorkValues = [];
        const fieldOfWorkCheckboxes = $forms.find('input[type="checkbox"][name="fieldOfWork"]:checked').not('#allFieldOfWork, #allmFieldOfWork');
        fieldOfWorkCheckboxes.each(function() {
            fieldOfWorkValues.push($(this).val());
        });
        if (fieldOfWorkValues.length > 0) {
            formData.append('fieldOfWork', fieldOfWorkValues.join(','));
        }

        // Behandelt Seniority
        const seniorityValues = [];
        const seniorityCheckboxes = $forms.find('input[type="checkbox"][name="seniority"]:checked').not('#allSeniority, #allmSeniority');
        seniorityCheckboxes.each(function() {
            seniorityValues.push($(this).val());
        });
        if (seniorityValues.length > 0) {
            formData.append('seniority', seniorityValues.join(','));
        }

        // Behandle Salary Range
        formData.append('salary_min', $('#salary_min').val());
        formData.append('salary_max', $('#salary_max').val());

        formData.append('action', 'clevermatch_fetch_candidates');
        formData.append('page', page);

        const limit = $('#cmCandidatesContainer').data('limit');
        if (limit) {
            formData.append('limit', limit);
        }

        console.log('Sending data:', formData.toString()); // Debugging

        $.ajax({
            url: clevermatch_ajax.ajax_url,
            type: 'POST',
            data: formData.toString(),
            processData: false,
            contentType: 'application/x-www-form-urlencoded',
            success: function(response) {
                enableInputs();
                hideLoadingSpinner();
                if (response.success && response.data.candidates && response.data.candidates.length > 0) {
                    const totalCandidates = response.data.totalno;
                    const limit = $('#cmCandidatesContainer').data('limit');

                    if (limit) {
                        response.data.candidates = response.data.candidates.slice(0, limit);
                    }

                    response.data.totalno = totalCandidates;

                    displayCandidates(response.data);
                    if (!limit) {
                        displayPagination(response.data.page, response.data.totalpages);
                    }

                    // Scrollt nach oben zum Kandidaten-Container
                    if (isPaginating) {
                        $('html, body').animate({
                            scrollTop: $('#cmCandidatesContainer').offset().top - 100
                        }, 'slow');
                    }

                } else {
                    displayNoResults();
                }
                updateFilterCounts();
            },

            error: function(xhr, status, error) {
                enableInputs();
                hideLoadingSpinner();
                console.error('AJAX error:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText);
                if (xhr.status === 200 && xhr.responseText.includes('Leider kein Kandidat mit diesen Vorgaben')) {
                    displayNoResults();
                } else {
                    displayError("Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.");
                }
            }
        });
    }

    function displayCandidates(data) {
        hideLoadingSpinner();
        var container = $('#cmCandidatesContainer');
        container.empty();

        const showCount = container.data('show-count') !== 'false';
        const limit = container.data('limit');

        if (data.totalno > 0) {
            if (showCount) {
                var resultText = data.totalno === 1 ? 'Kandidat' : 'Kandidaten';
                var countText;
                if (limit) {
                    countText = `${data.totalno} ${resultText} im Pool`;
                } else {
                    countText = `${data.totalno} ${resultText}`;
                }
                var resultCount = $('<div class="cm-result-count mb-3">').text(countText);
                container.append(resultCount);
            }

data.candidates.forEach(function(candidate) {
                var candidateUrl = candidate.Url;
                if (clevermatch_ajax.afid) {
                    candidateUrl = appendAfidToUrl(candidateUrl, clevermatch_ajax.afid);
                }
            
                var card = $('<a class="card" target="_blank">')
                    .attr('href', candidateUrl)
                    .append($('<div class="card-header">')
                        .append($('<div class="row g-2">')
                            .append($('<div class="col-10 col-xl-11 d-flex flex-column justify-content-start">')
                                .append($('<h4 class="card-title">').text(`${candidate.Title} (${candidate.Age})`))
                            )
                            .append($('<div class="col-2 col-xl-1 pt-1 pt-lg-0 dialogue d-flex flex-column justify-content-start">')
                                .append($('<div class="certified text-end pe-1">')
                                    .append(function() {
                                        if (candidate.CertificationLevel === 'Certified') {
                                            return $('<img>', {
                                                src: 'https://www.clevermatch.com/media/clevermatch-siegel.webp',
                                                height: 44,
                                                width: 44,
                                                alt: 'CleverMatch Siegel'
                                            });
                                        } else {
                                            return $('<img>', {
                                                src: 'https://www.clevermatch.com/media/qualified.webp',
                                                height: 44,
                                                width: 44,
                                                alt: 'CleverMatch qualifiziert'
                                            });
                                        }
                                    })
                                )
                            )
                        )
                    )
                    .append($('<div class="card-body mt-1">')
                        .append($('<table>')
                            .append($('<tr>')
                                .append($('<th>').text('Einsatzort: '))
                                .append($('<td>').text(candidate.Region))
                            )
                            .append($('<tr>')
                                .append($('<th>').text('Zielgehalt:'))
                                .append($('<td>').text(candidate.SalaryExpectations))
                            )
                            .append($('<tr>')
                                .append($('<th>').text('Branchenerfahrung:'))
                                .append($('<td>').text(candidate.Industry))
                            )
                        )
                    );
            
                // Füge den Button nur für den Limited-Shortcode hinzu
                if (limit && limit > 2) {
                    card.append($('<div class="card-footer px-2">')
                        .append($('<span class="btn btn-info btn-sm">')
                            .text('Mehr Details ')
                            .append($('<i class="fas fa-long-arrow-right">'))
                        )
                    );
                }
            
                container.append(card);
            });



            // Hilfsfunktion für Affiliate Links
            function appendAfidToUrl(url, afid) {
                if (url.includes('afid=')) {
                    return url; // afid already present, return original URL
                }
                var separator = url.indexOf('?') !== -1 ? '&' : '?';
                return url + separator + 'afid=' + encodeURIComponent(afid);
            }

            //  Meldung, wenn nicht alle Kandidaten angezeigt werden
            if (limit && data.totalno > limit) {
                var moreAvailable = $('<div class="cm-more-available small my-4">').text(`${data.totalno - limit} weitere Kandidaten gefunden`);
                container.append(moreAvailable);

                var buttonContainer = $('<div class="cm-btn-leadon mt-3">');

                var showAllButton = $('<a href="https://www.clevermatch.com/unternehmen/kandidatenpool/" class="btn btn-info" id="showAllCandidates">Alle gefundenen Kandidaten anzeigen</a>');
                buttonContainer.append(showAllButton);
                container.append(buttonContainer);

            }

        } else {
            displayNoResults();
        }
        // Zeige Paginierung nur, wenn kein Limit existiert
        if (!limit) {
            displayPagination(data.page, data.totalpages);
        }
    }

    // Funktion zum Serialisieren der Formularwerte
    function serializeFilters() {
        const $forms = $('#cmSearchForm, #cmFilterForm, #cmFilterModal');
        let filterData = {};

        $forms.find('input, select').each(function() {
            const $input = $(this);
            const name = $input.attr('name');
            const value = $input.val();

            if ($input.is(':checkbox')) {
                if ($input.is(':checked')) {
                    if (!filterData[name]) {
                        filterData[name] = [];
                    }
                    filterData[name].push(value);
                }
            } else if (name && value) {
                filterData[name] = value;
            }
        });

        // Konvertiere Arrays in kommagetrennte Strings
        for (let key in filterData) {
            if (Array.isArray(filterData[key])) {
                filterData[key] = filterData[key].join(',');
            }
        }
        return filterData;
    }

    // Event-Listener für den "Alle Kandidaten anzeigen" Button
    $(document).on('click', '#showAllCandidates', function(e) {
        e.preventDefault();
        const filterData = serializeFilters();
        const queryString = $.param(filterData);
        const baseUrl = $(this).attr('href');
        const targetUrl = baseUrl + (queryString ? '?' + queryString : '') + '#cmCandidates';
        window.location.href = targetUrl;
    });


    // Funktion zum Anwenden der Filter beim Laden der Seite
    function applyFiltersOnLoad() {
        const urlParams = new URLSearchParams(window.location.search);
        let filtersApplied = false;

        urlParams.forEach((value, key) => {
            const $input = $(`[name="${key}"]`);
            if ($input.length) {
                if ($input.is(':checkbox')) {
                    const values = value.split(',');
                    values.forEach(val => {
                        const $checkbox = $(`[name="${key}"][value="${val}"]`);
                        if ($checkbox.length) {
                            $checkbox.prop('checked', true);
                            filtersApplied = true;
                        }
                    });
                } else {
                    $input.val(value);
                    filtersApplied = true;
                }
            }
        });

        if (urlParams.toString()) {
            fetchCandidates(1);
        }
    }

    function displayPagination(currentPage, totalPages) {
        $('.cm-pagination').remove();
        if (totalPages > 1) {
            var paginationContainer = $('<nav aria-label="Page Navigation" class="cm-pagination mt-5">');
            var paginationList = $('<ul class="pagination justify-content-center">');
            paginationContainer.append(paginationList);

            // Vorherige Seite
            addPageItem('&laquo;', currentPage > 1 ? currentPage - 1 : null, 'Previous');

            // Erste Seite 
            addPageItem(1, 1);

            const maxVisiblePages = 3; // Reduziert, um Platz für Ellipsen zu lassen
            let startPage = Math.max(2, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages - 1, startPage + maxVisiblePages - 1);

            // startPage anpassen, wenn endPage am Maximum ist
            if (endPage === totalPages - 1) {
                startPage = Math.max(2, endPage - maxVisiblePages + 1);
            }

            // Linke Ellipse
            if (startPage > 2) {
                addEllipsis();
            }

            // Seitenzahlen
            for (let i = startPage; i <= endPage; i++) {
                addPageItem(i, i);
            }

            // Rechte Ellipse
            if (endPage < totalPages - 1) {
                addEllipsis();
            }

            // Letzte Seite
            if (totalPages > 1) {
                addPageItem(totalPages, totalPages);
            }

            // Nächste Seite
            addPageItem('&raquo;', currentPage < totalPages ? currentPage + 1 : null, 'Next');

            $('#cmCandidatesContainer').after(paginationContainer);
        }

        function addPageItem(text, pageNumber, ariaLabel) {
            var pageItem = $('<li class="page-item">').appendTo(paginationList);
            var pageLink = $('<a class="page-link" href="#">')
                .html(text)
                .appendTo(pageItem);

            if (pageNumber !== null) {
                pageLink.on('click', function(e) {
                    e.preventDefault();
                    fetchCandidates(pageNumber);
                });

                if (pageNumber === currentPage) {
                    pageItem.addClass('active');
                }
            } else {
                pageItem.addClass('disabled');
            }

            if (ariaLabel) {
                pageLink.attr('aria-label', ariaLabel);
            }
        }

        function addEllipsis() {
            $('<li class="page-item disabled"><span class="page-link">...</span></li>').appendTo(paginationList);
        }
    }

    function displayNoResults() {
        hideLoadingSpinner();
        $('#cmCandidatesContainer').html('<p>Leider kein Kandidat mit diesen Vorgaben.</p>');
        $('.cm-pagination').remove();
    }

    function displayError(message) {
        $('#cmCandidatesContainer').html(`<p class="error">${message}</p>`);
        $('.cm-pagination').remove();
    }

    //  Event-Listener cmSearchForm
    $('#cmSearchForm input[type="text"]').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            showLoadingSpinner();
            disableInputs();
            debouncedFetchCandidates();
        }
    });

    //  Event-Listener filterSubmit Button
    $('#filterSubmit').on('click', function(e) {
        e.preventDefault();
        disableInputs();
        debouncedFetchCandidates();
    });

    //  Event-Listener Filter Checkboxen
    $('#cmFilterForm input[type="checkbox"]').on('change', function() {
        disableInputs();
        debouncedFetchCandidates();
        updateFilterCounts();
    });

    $('.accordion-button').on('click', function() {
        updateFilterCounts();
    });

    //  Event-Listener Filter Checkboxen Mobil
    $('#filterModalApply').on('click', function(e) {
        e.preventDefault();
        showLoadingSpinner();
        disableInputs();
        debouncedFetchCandidates();
        $('#filterModal').modal('hide');
    });

    //  Event-Listener FilterReset Button
    $('#cmFilterReset, #cmFilterModalReset').on('click', function(e) {
        e.preventDefault();
        sessionStorage.removeItem('clevermatchFilters');
        const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        $('#cmSearchForm, #cmFilterForm, #cmFilterModal').each(function() {
            this.reset();
        });
        $('input[type="checkbox"]').prop('checked', false);
        $('input[type="text"], input[type="hidden"]').val('');
        updateSalaryRange();
        showLoadingSpinner();
        debouncedFetchCandidates();
        updateFilterCounts();
    });

    $(document).ready(function() {
        showLoadingSpinner();
        fetchCandidates(1);
        applyFiltersOnLoad();

    });
});