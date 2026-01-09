// Main Life Health Check functionality, rewritten to use jQuery document ready instead of IIFE pattern

jQuery(function ($) {
    'use strict';

    // Get localized CALD languages and gravity form ID
    const lhcFormId = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.gravityFormId)
        ? lifeHealthCheck.gravityFormId
        : 2;
    const lhcFormClass = 'life-health-check-form';
    const caldLanguages = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.caldLanguages)
        ? lifeHealthCheck.caldLanguages
        : {};

    const dvRedirectUrl = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.dvRedirectUrl)
        ? lifeHealthCheck.dvRedirectUrl
        : "https://www.diabetesvic.org.au/";

    const trackingEventPrefix = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.trackingEventPrefix)
        ? lifeHealthCheck.trackingEventPrefix
        : "English";

    // Helper function to get CALD text with fallback
    function getCaldText(key, defaultValue) {
        if (!caldLanguages || Object.keys(caldLanguages).length === 0) {
            return defaultValue;
        }

        const keys = key.split('.');
        let value = caldLanguages;

        for (let k of keys) {
            if (value && typeof value === 'object' && value[k] !== undefined) {
                value = value[k];
            } else {
                return defaultValue;
            }
        }

        return value || defaultValue;
    }

    // Helper function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Prevent Enter key from submitting form on intro/details pages
    // Only allow submit on the final questions page
    $(document).on('keypress keydown', `form.${lhcFormClass} input, form.${lhcFormClass} select, form.${lhcFormClass} textarea`, function (e) {
        // Check if Enter key was pressed (key code 13)
        if (e.which === 13 || e.keyCode === 13) {
            const $currentPage = $(this).closest('.gform_page');

            // If on intro or details page, prevent submit and click next button instead
            if ($currentPage.hasClass('intro') || $currentPage.hasClass('details')) {
                e.preventDefault();
                const $nextButton = $currentPage.find('.gform_next_button');
                if ($nextButton.length && !$nextButton.prop('disabled')) {
                    $nextButton.trigger('click');
                }
                return false;
            }

            // On questions page, allow default behavior only if on submit button or last field
            // Otherwise prevent to avoid accidental submission
            if ($currentPage.hasClass('questions')) {
                const $target = $(e.target);
                // Only allow if it's the submit button itself
                if (!$target.is('input[type="submit"]')) {
                    e.preventDefault();
                    return false;
                }
            }
        }
    });

    // Centralized validation function for details page (name + email + confirm-contact checkbox)
    function validateDetailsPageFields() {
        const detailsPage = $(`form.${lhcFormClass} .gform_page.details`);
        // Early return if not on visible details page
        if (!detailsPage.length) return;

        const firstNameField = detailsPage.find('.gfield.first_name');
        const lastNameField = detailsPage.find('.gfield.last_name');
        const emailField = detailsPage.find('.gfield.email');
        const confirmField = detailsPage.find('.gfield.confirm-contact');
        const nextButton = detailsPage.find('.gform_next_button');

        // Check if all three fields exist on this page
        if (!firstNameField.length || !lastNameField.length || !emailField.length || !confirmField.length || !nextButton.length) {
            return; // Not the details page, skip
        }

        // Check validation status
        const firstNameValid = firstNameField.hasClass('is_valid');
        const lastNameValid = lastNameField.hasClass('is_valid');
        const emailValid = emailField.hasClass('is_valid');
        const confirmChecked = confirmField.find('input[type=checkbox]:checked').length > 0;

        // Enable next button only if all three conditions are met
        const allValid = firstNameValid && lastNameValid && emailValid && confirmChecked;
        nextButton.prop('disabled', !allValid);
    }

    // Function to fill waist-result field based on visible waist-table and q11 select value
    function fillWaistResult() {
        const $q11Select = $(`form.${lhcFormClass} .gfield.q11 select`);
        const $waistResultAsiaField = $(`form.${lhcFormClass} .gfield.waist-result-asia-ab input[type="text"]`);
        const $waistResultOtherField = $(`form.${lhcFormClass} .gfield.waist-result-other input[type="text"]`);

        const $waistMapAsiaAb = {
            'Less than 90cm': 'Less than 90cm',
            'Less than 80cm': 'Less than 80cm',
            '90cm - 100cm': '90 - 100cm',
            '80cm - 90cm': '80-90cm',
            'More than 100cm': 'More than 100cm',
            'More than 90cm': 'More than 90cm',
        };
        const $waistMapOther = {
            'Less than 102cm': 'Less than 102 cm',
            'Less than 88cm': 'Less than 88 cm',
            '102cm - 110cm': '102-110cm',
            '88cm - 100cm': '88-100cm',
            'More than 110cm': 'More than 110cm',
            'More than 100cm': 'More than 100cm',
        };

        // Check if q11 and at least one waist result field exist
        if (!$q11Select.length || (!$waistResultAsiaField.length && !$waistResultOtherField.length)) {
            console.log('⚠️ Q11 select or waist-result fields not found');
            return;
        }

        // Get q3 and q4 values to determine which field to fill
        const $q3 = $(`form.${lhcFormClass} .gfield.q3 input[type=radio]:checked`);
        const $q4Select = $(`form.${lhcFormClass} .gfield.q4 select`);

        const q3Value = $q3.val() ? $q3.val().toString().trim().toLowerCase() : '';
        const q4Value = $q4Select.val() ? $q4Select.val().toString().trim().toLowerCase() : '';

        // Determine which field to fill: asia-ab if q3='yes' OR q4='Asia', otherwise other
        const isAsiaAb = q3Value === 'yes' || q4Value === 'asia';
        const $targetField = isAsiaAb ? $waistResultAsiaField : $waistResultOtherField;
        const $otherField = isAsiaAb ? $waistResultOtherField : $waistResultAsiaField;

        // Get selected value from q11 (e.g., "range1", "range2", "range3")
        const selectedRange = $q11Select.val();

        if (!selectedRange) {
            // Clear both fields if no selection
            if ($waistResultAsiaField.length) $waistResultAsiaField.val('');
            if ($waistResultOtherField.length) $waistResultOtherField.val('');
            return;
        }

        // Extract column number from range value (range1 -> 1, range2 -> 2, range3 -> 3)
        const columnMatch = selectedRange.match(/range(\d+)/);
        if (!columnMatch) {
            console.log('⚠️ Invalid range format:', selectedRange);
            return;
        }
        const rangeNumber = parseInt(columnMatch[1]);

        // Find visible waist-table
        const $visibleTable = $('table.waist-table:visible').first();

        if (!$visibleTable.length) {
            console.log('⚠️ No visible waist-table found');
            if ($waistResultAsiaField.length) $waistResultAsiaField.val('');
            if ($waistResultOtherField.length) $waistResultOtherField.val('');
            return;
        }

        // Detect table type: desktop (.-desktop) or mobile (.-mobile)
        const isDesktop = $visibleTable.hasClass('-desktop');
        const isMobile = $visibleTable.hasClass('-mobile');

        let waistText = '';

        if (isDesktop) {
            // DESKTOP TABLE STRUCTURE:
            // <thead><tr><th>Range</th><th>1</th><th>2</th><th>3</th></tr></thead>
            // <tbody><tr><td>Waist (cm)</td><td>Less than 90cm</td><td>90 — 100cm</td><td>More than 100cm</td></tr></tbody>

            const $waistRow = $visibleTable.find('tbody tr').filter(function () {
                return $(this).find('td').first().text().trim().toLowerCase().includes('waist');
            });

            if (!$waistRow.length) {
                console.log('⚠️ Waist row not found in desktop table');
                return;
            }

            // Get the td at column index (rangeNumber 1 = index 1, etc.)
            const $targetCell = $waistRow.find('td').eq(rangeNumber);

            if (!$targetCell.length) {
                console.log('⚠️ Column not found in desktop table');
                return;
            }

            waistText = $targetCell.text().trim();

        } else if (isMobile) {
            // MOBILE TABLE STRUCTURE:
            // <tbody>
            //   <tr><th>Waist (cm)</th><th>Range</th></tr>
            //   <tr><td>Less than 90cm</td><td>1</td></tr>
            //   <tr><td>90 — 100cm</td><td>2</td></tr>
            //   <tr><td>More than 100cm</td><td>3</td></tr>
            // </tbody>

            // Find the row where the second column (Range) matches rangeNumber
            const $targetRow = $visibleTable.find('tbody tr').filter(function () {
                const $cells = $(this).find('td');
                if ($cells.length >= 2) {
                    const rangeValue = $cells.eq(1).text().trim();
                    return rangeValue === rangeNumber.toString();
                }
                return false;
            });

            if (!$targetRow.length) {
                console.log('⚠️ Range row not found in mobile table');
                return;
            }

            // Get the first column (waist value)
            const $waistCell = $targetRow.find('td').first();
            waistText = $waistCell.text().trim();

        } else {
            console.log('⚠️ Table type not recognized (no -desktop or -mobile class)');
            return;
        }

        // Map waistText using the appropriate mapping object
        const waistMap = isAsiaAb ? $waistMapAsiaAb : $waistMapOther;
        const mappedValue = waistMap[waistText] || waistText; // Use mapped value if found, otherwise use original text

        // Fill the appropriate waist-result field and clear the other
        if ($targetField.length) {
            $targetField.val(mappedValue);
        }
        if ($otherField.length) {
            $otherField.val('');
        }

        // console.log('✅ Waist result filled:', {
        //     tableType: isDesktop ? 'desktop' : 'mobile',
        //     selectedRange: selectedRange,
        //     rangeNumber: rangeNumber,
        //     waistText: waistText,
        //     isAsiaAb: isAsiaAb,
        //     q3Value: q3Value,
        //     q4Value: q4Value
        // });
    }

    // Function to update radio button labels with first character
    function updateRadioButtonLabels() {
        $(`form.${lhcFormClass} .gfield_radio .gchoice label`).each(function () {
            const $label = $(this);
            const labelText = $label.text().trim();
            if (labelText) {
                const firstChar = labelText.charAt(0).toUpperCase();
                // Create a unique class for this specific label
                const uniqueClass = 'radio-label-' + Math.random().toString(36).substr(2, 9);
                $label.addClass(uniqueClass);

                // Add dynamic CSS for this specific label
                if (!$('#' + uniqueClass + '-style').length) {
                    $('<style id="' + uniqueClass + '-style">')
                        .text('.' + uniqueClass + '::before { content: "' + firstChar + '" !important; }')
                        .appendTo('head');
                }
            }
        });
    }

    function updateSidebarProgressSteps() {
        // Get all Gravity Forms steps
        const gformSteps = $(`.gform_wrapper .gf_page_steps .gf_step`);

        // Check if we're on confirmation page
        const confirmationPage = $('.gform_confirmation_wrapper').length > 0 ||
            $('.gform_confirmation_message').length > 0 ||
            $('.gform_wrapper').hasClass('gform_confirmation');

        // Mapping: sidebar steps to Gravity Forms steps
        const stepMapping = {
            'intro': 1,        // Step 1
            'details': 2,      // Step 2  
            'questions': [3, 4, 5]  // Steps 3, 4, 5 (all questions)
        };

        const heading = $('.sidebar .heading');

        if ($(`#gf_step_${lhcFormId}_1`).hasClass('gf_step_completed')) {
            $('.sidebar .languages').hide();
        }
        else {
            $('.sidebar .languages').show();
        }

        // Update heading text based on form state
        if (confirmationPage) {
            heading.text(getCaldText('main_heading.results', 'Results'));
            $('.sidebar .languages').hide();
        } else {
            // Check if intro step is completed
            const introStep = $(`#gf_step_${lhcFormId}_1`);
            if (introStep.length && introStep.hasClass('gf_step_completed')) {
                heading.text(getCaldText('main_heading.progress', 'Progress'));
            } else {
                heading.text(getCaldText('main_heading.get_started', 'Get started'));
            }
        }

        $('.life-health-check .sidebar .progress-steps .progress-step').each(function () {
            const $step = $(this);
            const stepType = $step.attr('class').match(/progress-step\s+(\w+)/);

            if (!stepType) return;

            const sidebarStepName = stepType[1];

            // Reset all states first
            $step.removeClass('active completed');

            // If we're on confirmation page, mark all steps as completed
            if (confirmationPage) {
                $step.addClass('completed');
                return; // Skip the rest of the logic
            }

            // Check if this step corresponds to current GForm step
            if (sidebarStepName === 'intro') {
                // Check step 1 status
                const step1 = $(`#gf_step_${lhcFormId}_1`);
                if (step1.length) {
                    if (step1.hasClass('gf_step_completed')) {
                        $step.addClass('completed');
                    } else if (step1.hasClass('gf_step_active')) {
                        $step.addClass('active');
                    }
                }
            } else if (sidebarStepName === 'details') {
                // Check step 2 status
                const step2 = $(`#gf_step_${lhcFormId}_2`);
                if (step2.length) {
                    if (step2.hasClass('gf_step_completed')) {
                        $step.addClass('completed');
                    } else if (step2.hasClass('gf_step_active')) {
                        $step.addClass('active');
                    }
                }
            } else if (sidebarStepName === 'questions') {
                // Check if any of steps 3, 4, 5 are active or completed
                let isActive = false;
                let isCompleted = false;

                stepMapping.questions.forEach(stepNum => {
                    const step = $(`#gf_step_${lhcFormId}_${stepNum}`);
                    if (step.length) {
                        if (step.hasClass('gf_step_active')) {
                            isActive = true;
                        }
                        if (step.hasClass('gf_step_completed')) {
                            isCompleted = true;
                        }
                    }
                });

                if (isActive) {
                    $step.addClass('active');
                } else if (isCompleted) {
                    $step.addClass('completed');
                }
            } else if (sidebarStepName === 'results') {
                // Check if we're on results page (usually after all steps completed)
                const allStepsCompleted = gformSteps.filter('.gf_step_completed').length === gformSteps.length;
                if (allStepsCompleted) {
                    $step.addClass('active');
                }
            }
        });
    }

    // Show/Hide q12 checkbox options based on q1 (gender) selection
    function updateQ12OptionsVisibility() {
        const $form = $(`form.${lhcFormClass}`);
        const $q1 = $form.find('.gfield.q1');
        const $q12 = $form.find('.gfield.q12');

        if (!$q1.length || !$q12.length) return;

        const selectedQ1 = ($q1.find('input[type=radio]:checked').val() || '').toString().trim().toLowerCase();
        const isFemale = selectedQ1 === 'female';

        // Target q12 choices by normalized input value: all lowercase, hyphenated
        const targetValues = ['gestational-diabetes', 'polycystic-ovarian-syndrome'];

        $q12.find('input[type=checkbox]').each(function () {
            const $input = $(this);
            const inputVal = ($input.val() || '').toString().trim().toLowerCase().replace(/\s+/g, '-');
            const match = targetValues.some(val => val.trim().toLowerCase() === inputVal);

            if (match) {
                const $choice = $input.closest('.gchoice');
                if (isFemale) {
                    $choice.show();
                } else {
                    // If currently checked, uncheck before hide
                    if ($input.prop('checked')) {
                        $input.prop('checked', false); // Don't trigger change to prevent recursion
                    }
                    $choice.hide();
                }
            }
        });
    }

    function trackEvent(name, params = {}) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            event: name,
            ...params
        });
    }

    // Initial call when document is ready
    if ($('body').hasClass('life-health-check')) {
        updateRadioButtonLabels();
        updateSidebarProgressSteps();
        updateQ12OptionsVisibility();

        let hasHCViewed = false;
        if (!hasHCViewed) {
            trackEvent(`${trackingEventPrefix}_HC`, {
                form_id: lhcFormId,
                language: trackingEventPrefix,
                step: 'intro'
            });
            hasHCViewed = true;
        }
    }

    // Auto-trigger debug function when select, radio, or checkbox fields change
    $(document).on('change', `form.${lhcFormClass} select, form.${lhcFormClass} input[type="radio"], form.${lhcFormClass} input[type="checkbox"]`, function () {
        const $changedField = $(this).closest('.gfield');

        // Small delay to let conditional logic render
        setTimeout(function () {
            // Only call fillWaistResult if the changed field is q1, q3, q4, or q11
            if ($changedField.hasClass('q1') || $changedField.hasClass('q3') ||
                $changedField.hasClass('q4') || $changedField.hasClass('q11')) {
                fillWaistResult();
            }

            // Call updateQ12OptionsVisibility when q1 (gender) changes
            if ($changedField.hasClass('q1')) {
                updateQ12OptionsVisibility();
            }
        }, 300);
    });

    // Update on Gravity Forms AJAX events
    $(document).on('gform_confirmation_loaded', function () {
        if ($('body').hasClass('life-health-check')) {
            updateRadioButtonLabels();
            updateSidebarProgressSteps();
            $(`form.${lhcFormClass}`).removeClass('loading');
            $(`header.top-nav`).addClass('hidden');
            // Animate scroll to the form, offset 220px, smooth
            let $formWrapper = $(`.life-health-check .form-wrapper`);
            if ($formWrapper.length) {
                $('html, body').animate({
                    scrollTop: Math.max($formWrapper.offset().top - 220, 0)
                }, 400, 'swing');
            }
            if ($('.form-wrapper .thank-you-mess').length === 0) {
                $('.form-wrapper .share-wrapper').show();
            }

            const ausdriskResult = $('input#ausdrisk-result').val().trim();

            trackEvent(`${trackingEventPrefix}_Results`, {
                form_id: lhcFormId,
                language: trackingEventPrefix,
                step: 'results'
            });

            if (ausdriskResult === 'eligible') {
                trackEvent(`${trackingEventPrefix}_Result_Eligible`, {
                    form_id: lhcFormId,
                    language: trackingEventPrefix,
                    step: 'results'
                });
                // Add hash to URL
                window.location.hash = 'result-eligible';
            }
            else {
                trackEvent(`${trackingEventPrefix}_Result_Ineligible`, {
                    form_id: lhcFormId,
                    language: trackingEventPrefix,
                    step: 'results'
                });
                // Add hash to URL
                window.location.hash = 'result-ineligible';
            }
        }
    });

    // Update on any AJAX form submission
    $(document).on('gform_post_render', function () {
        if ($('body').hasClass('life-health-check')) {
            updateRadioButtonLabels();
            updateSidebarProgressSteps();
            updateQ12OptionsVisibility();
            $(`form.${lhcFormClass}`).addClass('loading');
            setTimeout(function () {
                $(`form.${lhcFormClass}`).removeClass('loading');
            }, 300);
        }
    });

    // Update when form is loaded via AJAX
    $(document).on('gform_load_form', function () {
        if ($('body').hasClass('life-health-check')) {
            updateRadioButtonLabels();
            updateSidebarProgressSteps();
            updateQ12OptionsVisibility();
            $(`form.${lhcFormClass}`).addClass('loading');
            setTimeout(function () {
                $(`form.${lhcFormClass}`).removeClass('loading');
                $(`header.top-nav`).addClass('hidden');
            }, 300);
        }
    });

    // Update on field validation
    $(document).on('gform_field_validation', function () {
        if ($('body').hasClass('life-health-check')) {
            updateRadioButtonLabels();
            updateSidebarProgressSteps();
            updateQ12OptionsVisibility();
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    // Add loading class for page navigation, scroll to form with 500px offset, smooth animation
    $(document).on('gform_page_loaded', function () {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
            updateQ12OptionsVisibility();
            // Animate scroll to the form, offset 220px, smooth
            let $formWrapper = $(`.life-health-check .form-wrapper`);
            if ($formWrapper.length) {
                $('html, body').animate({
                    scrollTop: Math.max($formWrapper.offset().top - 220, 0)
                }, 400, 'swing');
            }

            setTimeout(function () {
                // Ensure proper selection of current visible intro page and show footer only if it exists
                const $introPage = $('.gform_page.intro:visible');
                const $postcodeField = $(`form.${lhcFormClass} .gfield.postcode`);
                if ($introPage.length && $postcodeField.hasClass('is_valid')) {
                    let $pageFooter = $introPage.find('.gform_page_footer');
                    if ($pageFooter.length) {
                        $pageFooter.addClass('active');
                    }
                }
            }, 500);

            setTimeout(function () {
                validateDetailsPageFields();
            }, 300);
        }
    });

    // Add loading class for form submission
    $(document).on('gform_ajax_submit', function () {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    // Remove loading class on validation errors
    $(document).on('gform_validation_errors', function () {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).removeClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    // Add loading class when clicking next/previous buttons
    $(document).on('click', '.gform_next_button, .gform_previous_button', function () {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    // Add loading class when submitting form
    $(document).on('submit', '.life-health-check', function () {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    $(document).on('click', `form.${lhcFormClass} .gform_page.questions input[type=submit]`, function () {
        trackEvent(`${trackingEventPrefix}_Check_Score`, {
            form_id: lhcFormId,
            language: trackingEventPrefix,
            step: 'questions'
        });
        // Add hash to URL
        window.location.hash = 'check-score';
    });

    $(document).on('click change input focus blur',
        `form.${lhcFormClass} .gform_page.details .gfield select, 
        form.${lhcFormClass} .gform_page.details .gfield input`,
        function () {
            validateDetailsPageFields();
        });

    let postcodeTimer = null;

    $(document).on('input', `form.${lhcFormClass} .gfield.postcode input[type=number]`, function () {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        const $input = $(this);
        const value = $.trim($input.val());
        const parentField = $input.closest('.gfield');
        const currentPage = $input.closest('.gform_page');
        const nextButton = currentPage.find('.gform_next_button');
        const pageFooter = currentPage.find('.gform_page_footer');
        const AcceptableNonVicMess = currentPage.find('.gfield.acceptable-non-vic-regions');

        // Clear previous timer
        if (postcodeTimer) {
            clearTimeout(postcodeTimer);
        }

        // Reset UI immediately while typing
        parentField.removeClass('gfield_error is_invalid is_valid');
        parentField.find('.validation_message').remove();
        AcceptableNonVicMess.hide();
        nextButton.prop('disabled', true);
        pageFooter.hide();

        // Do NOT validate until user finishes typing 4 digits
        if (!/^\d{0,4}$/.test(value) || value.length < 4) {
            return;
        }

        postcodeTimer = setTimeout(function () {
            // Load acceptable non-VIC postcodes
            let nonVicPostcodes = [];
            const nonVicInput = $('#non_vic_postcodes_json');
            if (nonVicInput.length && nonVicInput.val()) {
                try {
                    nonVicPostcodes = JSON.parse(nonVicInput.val());
                } catch (e) {
                    console.warn('Invalid JSON in non_vic_postcodes_json:', e);
                }
            }

            const isVicPostcode = /^(3\d{3}|8\d{3})$/.test(value);
            const isAcceptableNonVic = nonVicPostcodes.includes(value);

            // ❌ 4 digits but not valid
            if (!isVicPostcode && !isAcceptableNonVic) {
                AcceptableNonVicMess.slideDown(200);
                parentField.addClass('is_invalid');
                nextButton.prop('disabled', true);
                pageFooter.hide();
                return;
            }

            // ✅ Valid postcode
            parentField.addClass('is_valid');
            nextButton.prop('disabled', false);
            pageFooter.slideDown(200).css('display', 'flex');
            AcceptableNonVicMess.hide();

        }, 400); // debounce time
    }
    );


    // On change event for Full Name field in .life-health-check-form
    $(document).on('blur', `form.${lhcFormClass} .gfield.first_name input[type=text], form.${lhcFormClass} .gfield.last_name input[type=text]`, function () {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $input = $(this);
        let currentPage = $input.closest('.gform_page');
        let parentField = $input.closest('.gfield');
        let value = $.trim($input.val());

        setTimeout(function () {
            // Regex: single name with valid characters, length 2–50
            const nameRegex = /^[A-Za-zÀ-ỹ''\-\s]{2,50}$/;

            let isValid = nameRegex.test(value);

            if (!isValid) {
                parentField
                    .addClass('gfield_error is_invalid')
                    .removeClass('is_valid');

                if (parentField.find('.validation_message').length === 0) {
                    let validationText = '';
                    if (parentField.hasClass('first_name')) {
                        validationText = getCaldText(
                            'form_validation_message.validation_first_name',
                            'Please provide your first name - example: Jo'
                        );
                    } else {
                        validationText = getCaldText(
                            'form_validation_message.validation_last_name',
                            'Please provide your last name - example: Smith'
                        );
                    }
                    parentField.find('.ginput_container').append(
                        '<div class="gfield_description validation_message gfield_validation_message">' +
                        escapeHtml(validationText) +
                        '</div>'
                    );
                }

            } else {
                parentField
                    .removeClass('gfield_error is_invalid')
                    .addClass('is_valid')
                    .find('.validation_message')
                    .remove();
            }

        }, 300);
    });


    // On change event for email field in .life-health-check-form with email validation
    $(document).on('blur', `form.${lhcFormClass} .gfield.email input[type=email]`, function () {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $input = $(this);
        let currentPage = $input.closest('.gform_page');
        let parentField = $input.closest('.gfield');
        let value = $.trim($input.val());
        // Basic email validation regex
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let isEmailValid = emailPattern.test(value);

        setTimeout(function () {
            if (!value || value.trim().length === 0 || !isEmailValid) {
                parentField.addClass('gfield_error is_invalid').removeClass('is_valid');
                // Prevent multiple validation messages
                if (parentField.find('.validation_message').length === 0) {
                    const validationText = getCaldText('form_validation_message.validation_email', 'Please provide a valid email address - example: name@gmail.com');
                    parentField.find('.ginput_container').append('<div class="gfield_description validation_message gfield_validation_message">' + escapeHtml(validationText) + '</div>');
                }
            } else {
                parentField.removeClass('gfield_error is_invalid').addClass('is_valid').find('.validation_message').remove();
            }

        }, 300);

        $('input#lhc_user_email').val(value);
    });

    // On change event for select field in .life-health-check-form with email validation
    $(document).on('change', `form.${lhcFormClass} .gfield select.gfield_select`, function () {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $select = $(this);
        let currentPage = $select.closest('.gform_page');
        let parentField = $select.closest('.gfield');
        let nextButton = currentPage.find('.gform_next_button');
        let value = $.trim($select.val());
        let btnClear = '<span class="btn-clear-select"></span>';

        if (!value || value.trim().length === 0) {
            parentField.addClass('gfield_error is_invalid').removeClass('is_valid');
            parentField.find('.btn-clear-select').remove();
            nextButton.prop('disabled', true);
            // Prevent multiple validation messages
            if (parentField.find('.validation_message').length === 0) {
                const validationText = getCaldText('form_validation_message.validation_questions', 'Please select an option.');
                parentField.find('.ginput_container_select').append('<div class="gfield_description validation_message gfield_validation_message">' + escapeHtml(validationText) + '</div>');
            }
        } else {
            nextButton.prop('disabled', false);
            parentField.removeClass('gfield_error is_invalid').addClass('is_valid').find('.validation_message').remove();
            parentField.find('.ginput_container_select').append(btnClear);

            // Animate scroll to next visible gfield that is not a section, with offset top 200px
            let $nextField = parentField.nextAll('.gfield:visible').not('.gsection').not('.gfield_html').first();
            if ($nextField.length) {
                let targetScroll = $nextField.offset().top - 200;
                setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: targetScroll
                    }, 300, 'swing');
                    $('header.top-nav').addClass('hidden');
                }, 300);
            }
        }
    });

    $(document).on('click', '.gfield .btn-clear-select', function () {
        let $btn = $(this);
        let parentField = $btn.closest('.gfield');
        let select = parentField.find('select.gfield_select');
        let currentPage = parentField.closest('.gform_page');
        let nextButton = currentPage.find('.gform_next_button');

        // Clear the select value
        select.val('').trigger('change');

        // Remove the clear button itself
        $btn.remove();
        // Optionally, re-disable the Next button if needed
        nextButton.prop('disabled', true);
    });

    // On change event for checkbox fields to handle "None of the below" logic
    $(document).on('change input', `form.${lhcFormClass} .gfield_checkbox input[type=checkbox]`, function () {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $changed = $(this);
        let parentField = $changed.closest('.gfield');
        let currentPage = parentField.closest('.gform_page');
        let $checkboxes = parentField.find('input[type=checkbox]');

        if (parentField.hasClass('q12')) {
            // Find the "None of the below" checkbox (case-insensitive)
            let $noneCheckbox = $checkboxes.filter(function () {
                return $.trim($(this).val()).toLowerCase() === 'none';
            });
            if ($changed.is($noneCheckbox)) {
                // If "None of the below" is checked, uncheck all others
                $checkboxes.not($noneCheckbox).each(function () {
                    if ($(this).prop('checked')) {
                        $(this).prop('checked', false); // Don't trigger change to prevent recursion
                    }
                });
            } else {
                // If any box other than "None of the below" is checked, uncheck "None of the below"
                $noneCheckbox.prop('checked', false);
            }
        }
    });

    // On change event for radio fields
    $(document).on('change input', `form.${lhcFormClass} .gfield_radio input[type=radio]`, function () {
        let $inputRadio = $(this);
        let value = $.trim($inputRadio.val());
        let parentField = $inputRadio.closest('.gfield');

        if (value || value.trim().length > 0) {
            if (parentField.hasClass('diabetes') && value.toLowerCase() === 'yes') {
                setTimeout(function () {
                    window.open(dvRedirectUrl, '_blank');
                    return; // Stop further processing after redirect
                }, 450);
            }
            else {
                // Delay 300ms before scroll
                let $nextField = parentField.nextAll('.gfield:visible').not('.gsection').not('.gfield_html').first();
                if ($nextField.length) {
                    let targetScroll = $nextField.offset().top - 200;
                    setTimeout(function () {
                        $('html, body').animate({
                            scrollTop: targetScroll
                        }, 300, 'swing');
                        $('header.top-nav').addClass('hidden');
                    }, 300);
                }
            }
        }
    });

    let hasStartedHC = false;
    // On change event for radio fields
    $(document).on('click', `form.${lhcFormClass} .gform_page.intro .gform_next_button`, function () {
        // Prevent duplicate firing
        if (hasStartedHC) {
            return;
        }
        trackEvent(`${trackingEventPrefix}_StartHC`, {
            form_id: lhcFormId,
            language: trackingEventPrefix,
            step: 'intro'
        });
        // Add hash to URL
        window.location.hash = 'start-health-check';

        hasStartedHC = true;
    });

    let hasConfirmedHC = false;
    // On change event for radio fields
    $(document).on('click', `form.${lhcFormClass} .gform_page.details .gform_next_button`, function () {
        // Prevent duplicate firing
        if (hasConfirmedHC) {
            return;
        }
        trackEvent(`${trackingEventPrefix}_Confirm`, {
            form_id: lhcFormId,
            language: trackingEventPrefix,
            step: 'details'
        });
        // Add hash to URL
        window.location.hash = 'confirm';

        hasConfirmedHC = true;
    });

    // Final step form validation and submission
    $(document).on('submit', '.gform_confirmation_wrapper form.final-step-form', function (e) {
        e.preventDefault();
        if (!$(this).closest('.life-health-check').length) {
            return;
        }

        const $form = $(this);
        const $phoneInput = $form.find('#phone-number');
        const $validateMess = $form.find('.validate-mess');
        const phoneValue = $.trim($phoneInput.val());

        // Basic phone validation (at least 8 digits)
        const phoneRegex = /^[0-9\s\-\+\(\)]{8,}$/;
        const digitsOnly = phoneValue.replace(/\D/g, '');
        const isValidPhone = digitsOnly.length >= 8 && phoneRegex.test(phoneValue);

        // Reset validation state
        $phoneInput.removeClass('error');
        $validateMess.hide();

        if (!phoneValue || !isValidPhone) {
            $phoneInput.addClass('error');
            $validateMess.show();
            return false;
        }

        // Get email, entry ID, and phone field ID from hidden fields
        const email = $form.find('#input-ausdrisk-user-email').val();
        const entryId = $form.find('#input-ausdrisk-entry-id').val();
        const phoneFieldId = $form.find('#input-ausdrisk-phone-gfield-id').val();
        const resultFieldId = $form.find('#input-ausdrisk-result-gfield-id').val();
        const ausdriskResult = $form.find('#input-ausdrisk-result').val();

        if (!email) {
            $validateMess.text('Email not found. Please contact support.').show();
            return false;
        }
        if (!entryId) {
            $validateMess.text('Entry ID not found. Please contact support.').show();
            return false;
        }
        if (!phoneFieldId) {
            $validateMess.text('Configuration error. Please contact support.').show();
            return false;
        }
        if (!resultFieldId) {
            $validateMess.text('Configuration error. Please contact support.').show();
            return false;
        }

        // Disable submit button
        const $submitBtn = $form.find('#btn-ausdrisk-final-submit');
        $submitBtn.prop('disabled', true).val('Submitting...');

        trackEvent(`${trackingEventPrefix}_Submit_EOI`, {
            form_id: lhcFormId,
            language: trackingEventPrefix,
            step: 'results'
        });
        // Add hash to URL
        window.location.hash = 'submit-eoi';

        // Submit via AJAX
        $.ajax({
            url: (typeof lifeAjax !== 'undefined' && lifeAjax.ajaxurl) ? lifeAjax.ajaxurl : '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'life_update_lead_phone',
                nonce: (typeof lifeAjax !== 'undefined' && lifeAjax.updateLeadPhoneNonce) ? lifeAjax.updateLeadPhoneNonce : '',
                email: email,
                phone: phoneValue,
                entry_id: entryId,
                phone_field_id: phoneFieldId,
                result_field_id: resultFieldId,
                ausdrisk_result: ausdriskResult
            },
            success: function (response) {
                if (response.success) {
                    $form.find('.field, .input-container').hide();
                    var $thankYouMess = $('.gform_confirmation_wrapper .thank-you-mess');
                    $thankYouMess.slideDown(300, function () {
                        if ($thankYouMess.length) {
                            var containerOffset = $thankYouMess.offset().top;
                            var containerHeight = $thankYouMess.outerHeight();
                            var windowHeight = $(window).height();
                            var scrollTo = containerOffset - (windowHeight / 2) + (containerHeight / 2);
                            $('html, body').animate({ scrollTop: Math.max(scrollTo, 0) }, 300);

                            trackEvent(`${trackingEventPrefix}_Thankyou`, {
                                form_id: lhcFormId,
                                language: trackingEventPrefix,
                                step: 'results'
                            });
                            // Add hash to URL
                            window.location.hash = 'thankyou';
                        }
                    });
                    $('.form-wrapper .share-wrapper').show();
                } else {
                    $validateMess.text(response.data && response.data.message ? response.data.message : 'An error occurred. Please try again.').show();
                    $submitBtn.prop('disabled', false).val('Submit');
                }
            },
            error: function (xhr, status, error) {
                $validateMess.text('An error occurred. Please try again.').show();
                $submitBtn.prop('disabled', false).val('Submit');
            }
        });

        return false;
    });

    // Real-time phone validation on input
    $(document).on('input blur', '.final-step-form #phone-number', function () {
        const $input = $(this);
        const $form = $input.closest('.final-step-form');
        const $validateMess = $form.find('.validate-mess');
        const phoneValue = $.trim($input.val());

        if (phoneValue) {
            const phoneRegex = /^[0-9\s\-\+\(\)]{8,}$/;
            const digitsOnly = phoneValue.replace(/\D/g, '');
            const isValidPhone = digitsOnly.length >= 8 && phoneRegex.test(phoneValue);

            if (isValidPhone) {
                $input.removeClass('error');
                $validateMess.hide();
            } else {
                $input.addClass('error');
            }
        } else {
            $input.removeClass('error');
            $validateMess.hide();
        }
    });

}); // end main jQuery ready

// Gravity Forms Progressive Field Reveal (jQuery)
jQuery(function ($) {
    'use strict';

    // Progressive field reveal class
    class ProgressiveFieldReveal {
        constructor() {
            this.form = null;
            this.activeFieldIndex = 0;
            this.validFields = [];
            this.init();
        }

        // Initialize the progressive reveal
        init() {
            this.form = $('.life-health-check');
            if (!this.form.length) return;

            this.setupProgressiveReveal();
            this.bindEvents();
        }

        // Setup initial field states
        setupProgressiveReveal() {
            // Get current page fields only (for pagination support)
            const currentPage = this.form.find('.gform_page:visible');

            // Get all valid fields on current page (exclude sections, hidden, etc.)
            this.validFields = currentPage.find('.gfield').filter(function () {
                const $field = $(this);
                const fieldClass = $field.attr('class') || '';

                // Exclude fields with conditional logic hidden attribute
                if ($field.attr('data-conditional-logic') === 'hidden') {
                    return false;
                }

                // Exclude fields that don't need user interaction
                const excludeClasses = [
                    'gfield_html',           // HTML content fields
                    'gfield_hidden',         // Hidden fields
                    'gsection',            // Section dividers
                    'gfield_page',          // Page breaks
                    'gfield_captcha',       // CAPTCHA fields
                    'gfield_consent',        // Consent fields (if any)
                    'hidden_field',
                    'postcode',
                    'first_name',
                    'last_name',
                    'email',
                    'confirm-contact',
                    'waist-result-asia-ab',
                    'waist-result-other',
                ];

                // Check if field has any exclude classes
                const hasExcludeClass = excludeClasses.some(excludeClass =>
                    fieldClass.includes(excludeClass)
                );

                return !hasExcludeClass;
            });

            // Reset all fields on current page first
            currentPage.find('.gfield').removeClass('active-field disabled-field completed-field');

            // Track if we've found the first incomplete field
            let foundFirstIncomplete = false;

            // Apply initial states to valid fields on current page
            this.validFields.each((index, field) => {
                const $field = $(field);

                // Check if this field is already completed
                const isFieldCompleted = this.isFieldValid($field);

                // Check if this is a select field
                const isSelectField = $field.find('select.gfield_select').length > 0;
                let btnClear = '<span class="btn-clear-select"></span>';

                if (isFieldCompleted) {
                    // Field is completed, mark as completed
                    $field.addClass('completed-field').removeClass('active-field disabled-field');

                    // If it's a select field, also add is_valid class
                    if (isSelectField) {
                        $field.addClass('is_valid');
                        $field.find('.ginput_container_select').append(btnClear);
                    }
                } else if (!foundFirstIncomplete) {
                    // This is the first incomplete field, make it active
                    $field.addClass('active-field').removeClass('disabled-field completed-field');
                    foundFirstIncomplete = true;
                    this.activeFieldIndex = index;
                } else {
                    // Other incomplete fields are disabled/blurred
                    $field.addClass('disabled-field').removeClass('active-field completed-field');
                }
            });

            // Restore validity/completion states for visible fields (useful after page navigation)
            this.restoreFieldStates();

            // Sync q12-divider visibility with q12 field
            this.syncQ12DividerVisibility();

            // Disable page footer buttons initially
            this.updatePageFooterState();

            // Validate first field on load if there's an active field
            if (foundFirstIncomplete) {
                this.validateCurrentField();
            }
        }

        // Bind events to fields
        bindEvents() {
            // Listen for field changes
            this.form.on('change input blur', '.gfield input, .gfield select, .gfield textarea', (e) => {
                const $field = $(e.target).closest('.gfield');
                this.handleFieldChange($field);
            });

            // Listen for radio/checkbox changes
            this.form.on('change', '.gfield input[type="radio"], .gfield input[type="checkbox"]', (e) => {
                const $field = $(e.target).closest('.gfield');
                this.handleFieldChange($field);
            });

            // Listen for Gravity Forms events
            $(document).on('gform_post_render', () => {
                setTimeout(() => {
                    this.form = $('.life-health-check');
                    if (this.form.length) {
                        this.setupProgressiveReveal();
                        this.restoreFieldStates();
                        this.updatePageFooterState();
                    }
                }, 150);
            });

            $(document).on('gform_page_loaded', () => {
                setTimeout(() => {
                    this.setupProgressiveReveal();
                    this.restoreFieldStates();
                    this.updatePageFooterState();
                }, 150);
            });
        }

        // Handle field change and validation
        handleFieldChange($field) {
            if (this.isFieldValid($field)) {
                this.revealNextField($field);
            } else {
                // Field is no longer valid - mark as incomplete
                $field.removeClass('completed-field');
            }
            // Sync q12-divider visibility when ausdrisk-score changes
            if ($field.hasClass('ausdrisk-score')) {
                this.syncQ12DividerVisibility();
            }
            // Always update footer state whether field is valid or not
            this.updatePageFooterState();
        }

        // Check if field is valid
        isFieldValid($field) {
            // If Gravity Forms has marked this field as error, it's invalid
            if ($field.hasClass('gfield_error')) return false;

            const $inputs = $field.find('input, select, textarea');

            // Check each input in the field
            let isValid = true;
            $inputs.each((index, input) => {
                const $input = $(input);
                const tag = input.tagName.toLowerCase();
                const inputType = ($input.attr('type') || '').toLowerCase();

                if (inputType === 'radio') {
                    // For radio groups, check if any in the group is selected
                    const radioName = $input.attr('name');
                    const radioGroup = $field.find(`input[name="${radioName}"]`);
                    isValid = isValid && radioGroup.filter(':checked').length > 0;
                } else if (inputType === 'checkbox') {
                    // For checkboxes, check if any in the group is selected
                    const checkboxGroup = $field.find('input[type="checkbox"]');
                    isValid = isValid && checkboxGroup.filter(':checked').length > 0;
                } else if (tag === 'select') {
                    // For selects, check if value is not empty
                    const v = $input.val();
                    isValid = isValid && v !== '' && v !== null;
                } else {
                    // For text-like inputs and textarea, check if value is not empty
                    const v = ($input.val() || '').toString();
                    isValid = isValid && v.trim() !== '';
                }
            });

            return isValid;
        }

        // Reveal next field with animation
        revealNextField($currentField) {
            const currentIndex = this.validFields.index($currentField);

            if (currentIndex === -1) return;

            // Mark current field as completed
            $currentField.removeClass('active-field disabled-field').addClass('completed-field');

            // Show next field if available
            const nextIndex = currentIndex + 1;
            if (nextIndex < this.validFields.length) {
                const $nextField = $(this.validFields[nextIndex]);

                // Remove disabled class and add active class
                $nextField.removeClass('disabled-field').addClass('active-field');
            }
        }

        // Restore .is_valid and .completed-field based on current values and errors
        restoreFieldStates() {
            const currentPage = this.form.find('.gform_page:visible');
            currentPage.find('.gfield').each((_, el) => {
                const $field = $(el);
                const valid = this.isFieldValid($field);
                $field.toggleClass('is_valid', valid && !$field.hasClass('gfield_error'));
                if (valid) {
                    $field.addClass('completed-field').removeClass('disabled-field');
                } else {
                    // Field is not valid - remove completed status
                    $field.removeClass('completed-field');
                }
            });
            // Sync q12-divider visibility after restoring field states
            this.syncQ12DividerVisibility();
        }

        // Sync q12-divider section visibility based on ausdrisk-score value
        syncQ12DividerVisibility() {
            const $ausdriskScoreField = this.form.find('.gfield.ausdrisk-score');
            const $q12Divider = this.form.find('.gsection.q12-divider');

            if (!$ausdriskScoreField.length || !$q12Divider.length) return;

            // Get the ausdrisk-score input value
            const $scoreInput = $ausdriskScoreField.find('input[type="number"], input[type="text"]');
            const scoreValue = parseFloat($scoreInput.val()) || 0;

            // Show divider if score < 12, hide otherwise
            if (scoreValue < 12) {
                $q12Divider.show();
            } else {
                $q12Divider.hide();
            }
        }

        // Update page footer button states based on field completion
        updatePageFooterState() {
            const currentPage = this.form.find('.gform_page:visible');
            const pageFooter = currentPage.find('.gform_page_footer');

            if (!pageFooter.length) return;

            // Check if all fields on current page are completed (excluding conditionally hidden fields)
            let allFieldsCompleted = true;
            this.validFields.each((index, field) => {
                const $field = $(field);

                // Skip fields that are conditionally hidden
                if ($field.attr('data-conditional-logic') === 'hidden') {
                    return true; // continue to next field
                }

                if (!$field.hasClass('completed-field') && !this.isFieldValid($field)) {
                    allFieldsCompleted = false;
                    return false; // break the loop
                }
            });

            // Get all buttons in page footer
            const buttons = pageFooter.find('input[type="submit"], .gform_next_button, .gform_previous_button');

            buttons.each(function () {
                const $button = $(this);

                // Always enable Previous button
                if ($button.hasClass('gform_previous_button')) {
                    $button.prop('disabled', false);
                } else {
                    // Enable/disable Next and Submit buttons based on completion
                    $button.prop('disabled', !allFieldsCompleted);
                }
            });
        }

        // Validate current active field
        validateCurrentField() {
            const $activeField = this.validFields.eq(this.activeFieldIndex);
            if ($activeField.length && this.isFieldValid($activeField)) {
                this.revealNextField($activeField);
                this.activeFieldIndex++;
            }
        }

        // Reset to first field (useful for form resets)
        resetToFirstField() {
            this.activeFieldIndex = 0;

            this.validFields.each((index, field) => {
                const $field = $(field);
                $field.removeClass('active-field disabled-field completed-field');

                if (index === 0) {
                    $field.addClass('active-field');
                } else {
                    $field.addClass('disabled-field');
                }
            });
        }
    }

    // Initialize when DOM is ready
    function initProgressiveReveal() {
        new ProgressiveFieldReveal();
    }

    // Start the progressive reveal
    initProgressiveReveal();

    // Toggle active state and slide field-list for sidebar field labels
    $(document).on('click', '.sidebar .field-label.mobile', function () {
        var $label = $(this);
        var $field = $label.closest('.field');

        // Fix: Use toggleClass instead of non-existent classToggle, and more robust toggling of .field-list
        $field.toggleClass('active');

        // Only toggle field-list if it exists
        var $fieldList = $field.find('.field-list');
        if ($fieldList.length) {
            $fieldList.stop(true, true).slideToggle(200);
        }
    });

    // When resizing window and view width becomes > 767px, ensure .field-list is shown (slid down) in the sidebar fields
    (function () {
        $(window).on('resize', function () {
            let currWidth = $(window).width();

            if (!$('body').hasClass('life-health-check')) {
                return;
            }

            if (currWidth > 767) {
                // Remove .active from all .sidebar .field
                $('.sidebar .field.active').removeClass('active');

                // For each .sidebar .field .field-list that's hidden, slide it down
                $('.sidebar .field .field-list').each(function () {
                    if (!$(this).is(':visible')) {
                        $(this).stop(true, true).slideDown(200);
                    }
                });
            }
            else {
                // Remove .active from all .sidebar .field
                $('.sidebar .field.active').removeClass('active');

                $('.sidebar .field .field-list').each(function () {
                    if ($(this).is(':visible')) {
                        $(this).stop(true, true).slideUp(200);
                    }
                });
            }
        });
    })();

}); // end jQuery ready
