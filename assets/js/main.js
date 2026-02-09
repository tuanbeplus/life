// Main Life Health Check functionality, rewritten to use jQuery document ready instead of IIFE pattern
jQuery(function ($) {
    'use strict';

    // Define constants
    const lhcFormId = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.gravityFormId) ? lifeHealthCheck.gravityFormId : 2;
    const lhcFormClass = 'life-health-check-form';
    const caldLanguages = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.caldLanguages) ? lifeHealthCheck.caldLanguages : {};
    const ausdriskLanguage = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.ausdriskLanguage) ? lifeHealthCheck.ausdriskLanguage : 'english';
    const dvRedirectUrl = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.dvRedirectUrl) ? lifeHealthCheck.dvRedirectUrl : "/living-with-diabetes/";
    const trackingEventPrefix = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.trackingEventPrefix) ? lifeHealthCheck.trackingEventPrefix : "English";
    const submitLoadingText = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.submitLoadingText) ? lifeHealthCheck.submitLoadingText : "Submitting...";
    const submitButtonText = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.submitButtonText) ? lifeHealthCheck.submitButtonText : "Take the next step";
    const preLeadData = JSON.parse($('#pre_lead_data').val()) || {};
    const hcMainSection = $('body.life-health-check .health-check-section');
    const hcFormSidebar = hcMainSection.find('.sidebar');
    const hcFormWrapper = hcMainSection.find('.hc-form-wrapper');
    const hcForm = hcFormWrapper.find(`form.${lhcFormClass}`);
    const introPage = hcForm.find('.gform_page.intro');
    const detailsPage = hcForm.find('.gform_page.details');
    const questionsPage = hcForm.find('.gform_page.questions');
    const shareBtnText = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.shareBtnText) ? lifeHealthCheck.shareBtnText : "Share health check with a friend or family";

    const livingWithDiabetesField = introPage.find('.gfield.living_with_diabetes');
    const postCodeField = introPage.find('.gfield.postcode');
    const firstNameField = detailsPage.find('.gfield.first_name');
    const lastNameField = detailsPage.find('.gfield.last_name');
    const emailField = detailsPage.find('.gfield.email');
    const confirmContactField = detailsPage.find('.gfield.confirm_contact');

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

    // Helper function for responsive smooth scrolling
    // Uses native window.scrollTo on mobile (<767px) for better performance
    // Uses jQuery animate on desktop (>=767px) for smoother control and slower speed
    function smoothScrollTo(targetPosition, duration = 300) {
        const isMobile = $(window).width() < 767;

        if (isMobile) {
            // Mobile: use native smooth scroll (faster, better performance on iOS)
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        } else {
            // Desktop: use jQuery animate with custom duration for smoother, slower scroll
            $('html, body').animate({
                scrollTop: targetPosition
            }, duration, 'swing');
        }
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

            // On questions page, allow default behavior only if on submit/next button or last field
            // Otherwise prevent to avoid accidental submission
            if ($currentPage.hasClass('questions')) {
                const $target = $(e.target);
                // Only allow if it's a submit/next button (specifically exclude Previous button from Enter trigger)
                if (!$target.is('input[type="submit"]') || $target.hasClass('gform_previous_button')) {
                    e.preventDefault();
                    return false;
                }
            }
        }
    });

    // Centralized validation function for details page (name + email + confirm_contact checkbox)
    function validateDetailsPageFields() {
        const detailsPage = $(`form.${lhcFormClass} .gform_page.details`);
        // Early return if not on visible details page
        if (!detailsPage.length) return;

        const firstNameField = detailsPage.find('.gfield.first_name');
        const lastNameField = detailsPage.find('.gfield.last_name');
        const emailField = detailsPage.find('.gfield.email');
        const confirmField = detailsPage.find('.gfield.confirm_contact');
        const nextButton = detailsPage.find('.gform_next_button');

        nextButton.prop('disabled', true);

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
        if (allValid) {
            nextButton.prop('disabled', false);
        }
    }

    // Function to fill waist-result field based on visible waist-table and q11 select value
    function fillWaistResult() {
        const $q11Select = $(`form.${lhcFormClass} .gfield.q11 select`);
        const $waistResultAsiaField = $(`form.${lhcFormClass} .gfield.waist-result-asia-ab input[type="text"]`);
        const $waistResultOtherField = $(`form.${lhcFormClass} .gfield.waist-result-other input[type="text"]`);

        // Check if q11 and at least one waist result field exist
        if (!$q11Select.length || (!$waistResultAsiaField.length && !$waistResultOtherField.length)) {
            console.log('⚠️ Q11 select or waist-result fields not found');
            return;
        }

        // Get q1, q3 and q4 values to determine which field to fill
        const $q1 = $(`form.${lhcFormClass} .gfield.q1 input[type=radio]:checked`);
        const $q3 = $(`form.${lhcFormClass} .gfield.q3 input[type=radio]:checked`);
        const $q4Select = $(`form.${lhcFormClass} .gfield.q4 select`);

        const gender = $q1.val() ? $q1.val().toString().trim().toLowerCase() : '';
        const q3Value = $q3.val() ? $q3.val().toString().trim().toLowerCase() : '';
        const q4Value = $q4Select.val() ? $q4Select.val().toString().trim().toLowerCase() : '';

        // Determine category
        let category = '';
        if (q3Value === 'yes') {
            category = 'atsi';
        } else if (q4Value.startsWith('asia')) {
            category = 'asia';
        } else {
            category = 'other';
        }

        // Determine which field to fill: asia-ab if q3='yes' OR q4='Asia (including the Indian sub-continent)', otherwise other
        const isAsiaAb = q3Value === 'yes' || q4Value.startsWith('asia');
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
        const rangeIndex = parseInt(columnMatch[1]) - 1; // Convert to 0-based index

        // Get Salesforce value from waistTableData
        let sfValue = '';
        if (gender && waistTableData[gender] && waistTableData[gender][category]) {
            const rangeData = waistTableData[gender][category].ranges[rangeIndex];
            if (rangeData) {
                sfValue = rangeData.sfValue;
            }
        }

        // Fill the appropriate waist-result field and clear the other
        if ($targetField.length && sfValue) {
            $targetField.val(sfValue);
        }
        if ($otherField.length) {
            $otherField.val('');
        }
    }

    // Comprehensive waist table data structure
    // Format: gender -> category -> ranges (each range has display label and Salesforce value)
    const waistTableData = {
        _headers: {
            english: { waist: 'Waist (cm)', range: 'Range' },
            chinese_s: { waist: '腰围（厘米)', range: '范围' },
            chinese_t: { waist: '腰圍 (釐米)', range: '範圍' },
            arabic: { waist: 'الخصر (سم)', range: 'تصنيف' },
            vietnamese: { waist: 'Vòng eo (cm)', range: 'Phạm vi' }
        },
        male: {
            atsi: {  // Aboriginal or Torres Strait Islander = Yes
                ranges: [
                    { label: { english: 'Less than 90cm', chinese_s: '小于 90 厘米', chinese_t: '小於 90 釐米', arabic: 'أقل من 90 سم', vietnamese: 'Dưới 90cm' }, sfValue: 'Less than 90cm' },
                    { label: { english: '90cm - 100cm', chinese_s: '90至100厘米', chinese_t: '90 至 100 釐米', arabic: '90 سم - 100 سم', vietnamese: '90cm - 100cm' }, sfValue: '90 - 100cm' },
                    { label: { english: 'More than 100cm', chinese_s: '超过 100 厘米', chinese_t: '超過 100 釐米', arabic: 'أكثر من 100 سم', vietnamese: 'Hơn 100cm' }, sfValue: 'More than 100cm' }
                ]
            },
            asia: {  // ATSI = No, Ethnicity = Asia
                ranges: [
                    { label: { english: 'Less than 90cm', chinese_s: '小于 90 厘米', chinese_t: '小於 90 釐米', arabic: 'أقل من 90 سم', vietnamese: 'Dưới 90cm' }, sfValue: 'Less than 90cm' },
                    { label: { english: '90cm - 100cm', chinese_s: '90至100厘米', chinese_t: '90 至 100 釐米', arabic: '90 سم - 100 سم', vietnamese: '90cm - 100cm' }, sfValue: '90 - 100cm' },
                    { label: { english: 'More than 100cm', chinese_s: '超过 100 厘米', chinese_t: '超過 100 釐米', arabic: 'أكثر من 100 سم', vietnamese: 'Hơn 100cm' }, sfValue: 'More than 100cm' }
                ]
            },
            other: {  // ATSI = No, Ethnicity = Not Asia
                ranges: [
                    { label: { english: 'Less than 102cm', chinese_s: '小于 102 厘米', chinese_t: '小於 102 釐米', arabic: 'أقل من 102 سم', vietnamese: 'Dưới 102cm' }, sfValue: 'Less than 102 cm' },
                    { label: { english: '102cm - 110cm', chinese_s: '102至110厘米', chinese_t: '102 至 110 釐米', arabic: '102 سم - 110 سم', vietnamese: '102cm - 110cm' }, sfValue: '102-110cm' },
                    { label: { english: 'More than 110cm', chinese_s: '超过 110 厘米', chinese_t: '超過 110 釐米', arabic: 'أكثر من 110 سم', vietnamese: 'Hơn 110cm' }, sfValue: 'More than 110cm' }
                ]
            }
        },
        female: {
            atsi: {  // Aboriginal or Torres Strait Islander = Yes
                ranges: [
                    { label: { english: 'Less than 80cm', chinese_s: '小于 80 厘米', chinese_t: '小於 80 釐米', arabic: 'أقل من 80 سم', vietnamese: 'Dưới 80cm' }, sfValue: 'Less than 80cm' },
                    { label: { english: '80cm - 90cm', chinese_s: '80至90厘米', chinese_t: '80 至 90 釐米', arabic: '80-90 سم', vietnamese: '80 - 90cm' }, sfValue: '80-90cm' },
                    { label: { english: 'More than 90cm', chinese_s: '超过 90 厘米', chinese_t: '超過 90 釐米', arabic: 'أكثر من 90 سم', vietnamese: 'Hơn 90cm' }, sfValue: 'More than 90cm' }
                ]
            },
            asia: {  // ATSI = No, Ethnicity = Asia
                ranges: [
                    { label: { english: 'Less than 80cm', chinese_s: '小于 80 厘米', chinese_t: '小於 80 釐米', arabic: 'أقل من 80 سم', vietnamese: 'Dưới 80cm' }, sfValue: 'Less than 80cm' },
                    { label: { english: '80cm - 90cm', chinese_s: '80至90厘米', chinese_t: '80 至 90 釐米', arabic: '80-90 سم', vietnamese: '80 - 90cm' }, sfValue: '80-90cm' },
                    { label: { english: 'More than 90cm', chinese_s: '超过 90 厘米', chinese_t: '超過 90 釐米', arabic: 'أكثر من 90 سم', vietnamese: 'Hơn 90cm' }, sfValue: 'More than 90cm' }
                ]
            },
            other: {  // ATSI = No, Ethnicity = Not Asia
                ranges: [
                    { label: { english: 'Less than 88cm', chinese_s: '小于 88 厘米', chinese_t: '小於 88 釐米', arabic: 'أقل من 88 سم', vietnamese: 'Dưới 88cm' }, sfValue: 'Less than 88 cm' },
                    { label: { english: '88cm - 100cm', chinese_s: '88至100厘米', chinese_t: '88 至 100 釐米', arabic: '88-100سم', vietnamese: '88 - 100cm' }, sfValue: '88-100cm' },
                    { label: { english: 'More than 100cm', chinese_s: '超过 100 厘米', chinese_t: '超過 100 釐米', arabic: 'أكثر من 100 سم', vietnamese: 'Hơn 100cm' }, sfValue: 'More than 100cm' }
                ]
            }
        }
    };

    // Function to render table HTML from ranges data
    function renderWaistTable(rangesData) {
        const headers = waistTableData._headers[ausdriskLanguage] || waistTableData._headers.english;
        const labels = rangesData.map(r => r.label[ausdriskLanguage] || r.label.english);

        const desktopTable = `
            <table class="-desktop waist-table">
                <thead>
                    <tr>
                        <th>${headers.range}</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>${headers.waist}</td>
                        <td>${labels[0]}</td>
                        <td>${labels[1]}</td>
                        <td>${labels[2]}</td>
                    </tr>
                </tbody>
            </table>
        `;

        const mobileTable = `
            <table class="-mobile waist-table">
                <tbody>
                    <tr>
                        <th>${headers.waist}</th>
                        <th>${headers.range}</th>
                    </tr>
                    <tr>
                        <td>${labels[0]}</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>${labels[1]}</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>${labels[2]}</td>
                        <td>3</td>
                    </tr>
                </tbody>
            </table>
        `;

        return desktopTable + mobileTable;
    }

    // Function to get appropriate waist table HTML based on gender, ATSI status, and ethnicity
    function getWaistTableHTML(gender, atsiStatus, ethnicity) {
        // Determine category: atsi, asia, or other
        let category = '';
        if (atsiStatus === 'yes') {
            category = 'atsi';
        } else if (ethnicity.startsWith('asia')) {
            category = 'asia';
        } else {
            category = 'other';
        }

        // Get ranges data from waistTableData
        const genderData = waistTableData[gender];
        if (!genderData) return '';

        const categoryData = genderData[category];
        if (!categoryData || !categoryData.ranges) return '';

        return renderWaistTable(categoryData.ranges);
    }

    // Function to update waist table inside .gfield.q11 .gfield_description
    function updateWaistTable() {
        const $form = $(`form.${lhcFormClass}`);
        const $q1 = $form.find('.gfield.q1 input[type=radio]:checked');
        const $q3 = $form.find('.gfield.q3 input[type=radio]:checked');
        const $q4Select = $form.find('.gfield.q4 select');
        const $q11Description = $form.find('.gfield.q11 .gfield_description');

        // If q11 description doesn't exist, exit early
        if (!$q11Description.length) {
            return;
        }

        // Get current values
        const gender = $q1.val() ? $q1.val().toString().trim().toLowerCase() : '';
        const atsiStatus = $q3.val() ? $q3.val().toString().trim().toLowerCase() : '';
        const ethnicity = $q4Select.val() ? $q4Select.val().toString().trim().toLowerCase() : '';

        // If we don't have required values, don't update table
        if (!gender) {
            return;
        }

        // Get the appropriate table HTML
        const tableHTML = getWaistTableHTML(gender, atsiStatus, ethnicity);

        // Find or create the waist-table-container
        let $container = $q11Description.find('.waist-table-container');

        if (!$container.length) {
            // Create container if it doesn't exist
            $container = $('<div class="waist-table-container"></div>');
            $q11Description.append($container);
        }

        // Update container with new table HTML
        $container.html(tableHTML);

        // After updating table, trigger fillWaistResult to update the result field
        setTimeout(function () {
            fillWaistResult();
        }, 100);
    }


    // Function to update radio button labels with first character
    function updateRadioButtonLabels() {
        // PERF: The old approach injected a new <style> per label per render (random class),
        // which can create thousands of style tags during GF AJAX navigation.
        // This version is idempotent: one global style rule + a data attribute per label.

        const styleId = 'lhc-radio-first-char-style';
        if (!document.getElementById(styleId)) {
            const style = document.createElement('style');
            style.id = styleId;
            style.textContent = `
                form.${lhcFormClass} .gfield_radio .gchoice label[data-radio-first-char]::before {
                    content: attr(data-radio-first-char) !important;
                }
            `;
            document.head.appendChild(style);
        }

        $(`form.${lhcFormClass} .gfield_radio .gchoice label`).each(function () {
            const $label = $(this);

            let parentField = $label.closest('.gfield');

            if (parentField.hasClass('q9')) {
                return;
            }

            // Skip if already processed
            if ($label.attr('data-radio-first-char')) return;

            const labelText = ($label.text() || '').trim();
            if (!labelText) return;

            const match = labelText.match(/[a-zA-Z0-9]/);
            if (match) {
                $label.attr('data-radio-first-char', match[0].toUpperCase());
            }
        });
    }

    function updateSidebarProgressSteps() {
        // PERF: Scope DOM queries to the Health Check form only (avoid scanning other GF instances).
        const gformSteps = hcFormWrapper.find(`.gf_page_steps .gf_step`);

        // Check if we're on confirmation page
        const confirmationPage = hcFormWrapper.find('.gform_confirmation_wrapper').length > 0 ||
            hcFormWrapper.find('.gform_confirmation_message').length > 0 ||
            hcFormWrapper.hasClass('gform_confirmation');

        // Mapping: sidebar steps to Gravity Forms steps
        const stepMapping = {
            'intro': 1,        // Step 1
            'details': 2,      // Step 2  
            'questions': [3, 4, 5]  // Steps 3, 4, 5 (all questions)
        };

        if (hcFormWrapper.find(`#gf_step_${lhcFormId}_1`).hasClass('gf_step_completed')) {
            hcFormSidebar.find('.languages').hide();
            hcFormSidebar.find('.get-in-touch').hide();
        }
        else {
            hcFormSidebar.find('.languages').show();
            hcFormSidebar.find('.get-in-touch').show();
        }

        // Update based on form state
        if (confirmationPage) {
            hcFormSidebar.find('.progress-checklist .field-label').text(getCaldText('main_heading.results', 'Results'));
            hcFormSidebar.find('.languages').hide();
            hcFormSidebar.find('.get-in-touch').show();
        }

        hcFormSidebar.find('.progress-steps .progress-step').each(function () {
            const $step = $(this);
            const stepType = $step.attr('class').match(/progress-step\s+(\w+)/);

            if (!stepType) return;

            const sidebarStepName = stepType[1];

            // Reset all states first
            $step.removeClass('active completed');

            // If we're on confirmation page, mark all steps as completed
            if (confirmationPage) {
                if ($step.hasClass('results')) {
                    $step.addClass('active completed');
                }
                else {
                    $step.removeClass('active');
                }
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
        if ($('body').hasClass('en')) {
            updateRadioButtonLabels();
        }
        updateSidebarProgressSteps();
        updateQ12OptionsVisibility();
        updateWaistTable(); // Initialize waist table on page load

        let hasHCViewed = false;
        if (!hasHCViewed) {
            trackEvent(`${trackingEventPrefix}_HC`, {
                form_id: lhcFormId,
                language: trackingEventPrefix,
                step: 'intro'
            });
            hasHCViewed = true;
        }

        $('.share-wrapper .button span').text(shareBtnText);
    }

    // Q12 Mutual Exclusivity Logic
    function handleQ12Interactions() {
        const $q12 = $(`form.${lhcFormClass} .gfield.q12`);
        if (!$q12.length) return;

        // "None" option value - verified assumption or allow for partial match if needed
        const noneValue = 'none';

        $q12.find('input[type="checkbox"]').on('change', function () {
            const $this = $(this);
            const val = ($this.val() || '').toLowerCase();
            const isNone = val === noneValue;

            if ($this.is(':checked')) {
                if (isNone) {
                    // If "None" is checked, uncheck everything else
                    $q12.find('input[type="checkbox"]').not($this).prop('checked', false);
                } else {
                    // If any other option is checked, uncheck "None"
                    $q12.find(`input[type="checkbox"][value="${noneValue}"]`).prop('checked', false); // case insensitive check
                    // Also try finding by label text if value check fails? 
                    // Usually value is reliable, but let's stick to value for now. 
                    // NOTE: User said "value 'None'", so we assume "None" or "none".
                    $q12.find('input[type="checkbox"]').filter(function () {
                        return $(this).val().toLowerCase() === noneValue;
                    }).prop('checked', false);
                }
            }
            validateQ12()
        });
    }

    // Q12 Validation Logic
    function validateQ12() {
        const $q12 = $(`form.${lhcFormClass} .gfield.q12`);
        // Only validate if q12 is visible and exists
        if (!$q12.length || !$q12.is(':visible')) return true;

        const isChecked = $q12.find('input[type="checkbox"]:checked').length > 0;
        const $nextButton = $q12.closest('.gform_page').find('.gform_next_button, input[type="submit"]');
        const validationText = getCaldText('form_validation_message.validation_questions', 'Please select an option.');

        if (!isChecked) {
            // Add error class/message if needed for visual feedback
            $q12.addClass('gfield_error');
            if ($q12.find('.validation_message').length === 0) {
                $q12.append('<div class="validation_message">' + validationText + '</div>');
            }
            // Disable next button?
            $nextButton.prop('disabled', true);
            return false;
        } else {
            $q12.removeClass('gfield_error');
            $q12.find('.validation_message').remove();
            $nextButton.prop('disabled', false);
            return true;
        }
    }

    // Auto-trigger debug function when select, radio, or checkbox fields change
    $(document).on('change', `form.${lhcFormClass} select, form.${lhcFormClass} input[type="radio"], form.${lhcFormClass} input[type="checkbox"]`, function () {
        const $changedField = $(this).closest('.gfield');

        // Small delay to let conditional logic render
        setTimeout(function () {
            // Update waist table when q1, q3, or q4 changes
            if ($changedField.hasClass('q1') || $changedField.hasClass('q3') || $changedField.hasClass('q4')) {
                updateWaistTable();
            }

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
            if ($('body').hasClass('en')) {
                updateRadioButtonLabels();
            }
            updateSidebarProgressSteps();
            $(`form.${lhcFormClass}`).removeClass('loading');
            $(`header.top-nav`).addClass('hidden');
            $('.sidebar .get-started-section .desc').hide();
            $('.health-check-section .sidebar').addClass('mobile-hidden');

            const ausdriskScore = $('input#input-ausdrisk-score').val().trim();
            const ausdriskResult = $('input#ausdrisk-tracking-result').val().trim();

            // Animate scroll to the form, offset 220px, smooth
            if (hcFormWrapper.length) {
                if (ausdriskScore) {
                    let confirmationMessage = hcFormWrapper.find('.gform_confirmation_message');
                    if (confirmationMessage.length) {
                        let html = confirmationMessage.html();
                        confirmationMessage.html(html.replace('[ausdrisk_score]', ausdriskScore));
                    }
                }
                smoothScrollTo(Math.max(hcFormWrapper.offset().top - 220, 0), 300);
            }

            if (ausdriskResult && ausdriskResult === 'ineligible') {
                $('.hc-form-wrapper .share-wrapper').show();
            }

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
    $(document).on('gform_post_render', function (event, form_id, current_page) {
        if ($('body').hasClass('life-health-check')) {
            if ($('body').hasClass('en')) {
                updateRadioButtonLabels();
            }
            updateSidebarProgressSteps();
            updateQ12OptionsVisibility();
            updateWaistTable();
            $(`form.${lhcFormClass}`).addClass('loading');
            setTimeout(function () {
                $(`form.${lhcFormClass}`).removeClass('loading');
            }, 300);
        }
        if ($(`form.${lhcFormClass}`).length > 0) {
            $(`form.${lhcFormClass} .gform_page.intro .gform_next_button`)
                .attr('id', 'btn-start-hc');

            $(`form.${lhcFormClass} .gform_page.details .gform_next_button`)
                .attr('id', 'btn-confirm-hc');

            $(`form.${lhcFormClass} .gform_page.questions .gform_next_button`)
                .attr('id', 'btn-check-score-hc');
        }

        if (preLeadData && preLeadData.Status === 'No Score') {

            smoothScrollTo(Math.max(hcFormWrapper.offset().top - 220, 0), 300);

            const wrapper = document.getElementById(`gform_wrapper_${lhcFormId}`);
            if (!wrapper) return;

            // Show spinner immediately
            hcFormWrapper.find('#loading-spinner').show();

            // Field pre-filling as a fallback
            livingWithDiabetesField.find('input[type="radio"][value="No"]').prop('checked', true);
            postCodeField.find('input[type="number"]').val(0).val(preLeadData.PostalCode).focus().blur();
            confirmContactField.find('input[type="checkbox"]').prop('checked', true);
            firstNameField.find('input[type="text"]').val(preLeadData.FirstName).focus().blur();
            lastNameField.find('input[type="text"]').val(preLeadData.LastName).focus().blur();
            emailField.find('input[type="email"]').val(preLeadData.Email).focus().blur();

            if (current_page >= 3) {
                wrapper.classList.add('auto-paging');
                hcFormWrapper.find('#loading-spinner').remove();
                return;
            }

            if (wrapper.dataset.autoPaging === '1' || wrapper.classList.contains('auto-paging')) return;

            const formEl = wrapper.querySelector('form');
            if (!formEl) return;

            wrapper.dataset.autoPaging = '1';

            // Wait for GF to bind internal events before clicking next
            setTimeout(() => {
                const sourceInput = formEl.querySelector(`input[name="gform_source_page_number_${lhcFormId}"]`);
                const targetInput = formEl.querySelector(`input[name="gform_target_page_number_${lhcFormId}"]`);
                const nextBtn = $(formEl).find('.gform_next_button:visible').get(0) || formEl.querySelector('.gform_next_button');

                if (sourceInput && targetInput && nextBtn) {
                    sourceInput.value = current_page;
                    targetInput.value = parseInt(current_page) + 1;
                    nextBtn.click();
                }

                // Clean URL: remove everything after # and the # itself
                if (window.location.hash) {
                    history.replaceState(null, null, window.location.href.split('#')[0]);
                }

                wrapper.dataset.autoPaging = '0';

            }, 150);
        }
        else if (preLeadData && preLeadData.Status === 'No EOI') {
            let heading = hcMainSection.find('.sidebar .heading');
            heading.text(getCaldText('main_heading.results', 'Results'));
            hcMainSection.find('.gform_wrapper').remove();
            hcMainSection.find('.sidebar').addClass('mobile-hidden');
            hcMainSection.find('.sidebar .languages').hide();

            hcMainSection.find('.sidebar .progress-steps .progress-step').each(function () {
                const $step = $(this);
                $step.addClass('completed');
            });

            smoothScrollTo(Math.max(hcFormWrapper.offset().top - 220, 0), 300);
        }

    });

    // Update when form is loaded via AJAX
    $(document).on('gform_load_form', function () {
        if ($('body').hasClass('life-health-check')) {
            if ($('body').hasClass('en')) {
                updateRadioButtonLabels();
            }
            updateSidebarProgressSteps();
            updateQ12OptionsVisibility();
            updateWaistTable();
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
            if ($('body').hasClass('en')) {
                updateRadioButtonLabels();
            }
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
            updateWaistTable();
            // Animate scroll to the form, offset 220px, smooth
            let $formWrapper = $(`.life-health-check .hc-form-wrapper`);
            if ($formWrapper.length) {
                smoothScrollTo(Math.max($formWrapper.offset().top - 220, 0), 300);
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
        if ($(this).hasClass('gform_previous_button')) {
            return;
        }
        trackEvent(`${trackingEventPrefix}_Check_Score`, {
            form_id: lhcFormId,
            language: trackingEventPrefix,
            step: 'questions'
        });
        // Add hash to URL
        window.location.hash = 'check-score';
    });

    $(document).on('click', `form.${lhcFormClass} .gform_page.questions .gform_previous_button__custom`, function () {
        detailsPage.show();
        questionsPage.hide();
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
        parentField.removeClass('gfield_error is_invalid is_valid').addClass('is_typing');
        parentField.find('.validation_message').remove();
        AcceptableNonVicMess.hide();
        nextButton.prop('disabled', true);
        pageFooter.hide().removeClass('active');

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

        postcodeTimer = setTimeout(function () {
            // Empty - do nothing
            if (value.length === 0) {
                parentField.removeClass('is_typing');
                return;
            }

            // Invalid format (not exactly 4 digits or contains non-digits)
            if (!/^\d{4}$/.test(value)) {
                parentField.removeClass('is_typing');
                parentField.addClass('gfield_error is_invalid');
                const validationText = getCaldText('form_validation_message.validation_postcode', 'Please enter a valid postcode');
                parentField.find('.ginput_container').append(
                    '<div class="gfield_description validation_message gfield_validation_message">' +
                    escapeHtml(validationText) +
                    '</div>'
                );
                return;
            }

            // Valid format (4 digits) - check if it's in our service area
            const isVicPostcode = /^(3\d{3}|8\d{3})$/.test(value);
            const isAcceptableNonVic = nonVicPostcodes.includes(value);

            if (isVicPostcode || isAcceptableNonVic) {
                // ✅ Valid postcode in service area
                parentField.removeClass('is_typing');
                parentField.addClass('is_valid');
                nextButton.prop('disabled', false);
                pageFooter.slideDown(200).addClass('active');
            } else {
                // ❌ Valid format but not in service area
                parentField.removeClass('is_typing');
                parentField.addClass('is_invalid');
                AcceptableNonVicMess.slideDown(200);
            }
        }, 500);
    });

    // On change event for Full Name field in .life-health-check-form
    $(document).on('change input blur', `form.${lhcFormClass} .gfield.first_name input[type=text], form.${lhcFormClass} .gfield.last_name input[type=text]`, function () {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $input = $(this);
        let currentPage = $input.closest('.gform_page');
        let parentField = $input.closest('.gfield');
        let value = $.trim($input.val());
        currentPage.find('.gform_next_button').prop('disabled', true);

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
                            'Please provide your first name - example: John'
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
            validateDetailsPageFields();

        }, 300);
    });


    // On change event for email field in .life-health-check-form with email validation
    $(document).on('change input blur', `form.${lhcFormClass} .gfield.email input[type=email]`, function () {
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
        currentPage.find('.gform_next_button').prop('disabled', true);

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
            validateDetailsPageFields();

        }, 300);
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
                    smoothScrollTo(targetScroll, 300);
                    $('header.top-nav').addClass('hidden');
                }, 300);
            }
        }

        if (parentField.hasClass('q11') || parentField.hasClass('q12')) {
            parentField.click();
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
        let currentPage = $changed.closest('.gform_page');
        let parentField = $changed.closest('.gfield');

        if (parentField.hasClass('q12')) {
            handleQ12Interactions();
        }

        if (parentField.hasClass('confirm_contact')) {
            currentPage.find('.gform_next_button').prop('disabled', true);
            validateDetailsPageFields();
        }

        if (parentField.hasClass('q11') || parentField.hasClass('q12')) {
            parentField.click();
        }
    });

    // On change event for radio fields
    $(document).on('change input', `form.${lhcFormClass} .gfield_radio input[type=radio]`, function () {
        let $inputRadio = $(this);
        let value = $.trim($inputRadio.val());
        let parentField = $inputRadio.closest('.gfield');

        if (value || value.trim().length > 0) {
            if (parentField.hasClass('living_with_diabetes') && value.toLowerCase() === 'yes') {
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
                        smoothScrollTo(targetScroll, 300);
                        $('header.top-nav').addClass('hidden');
                    }, 300);
                }
            }
        }

        if (parentField.hasClass('q11') || parentField.hasClass('q12')) {
            parentField.click();
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
    let detailsNextClickCount = 0;
    // On change event for radio fields
    $(document).on('click', `form.${lhcFormClass} .gform_page.details .gform_next_button`, function () {
        const $detailsPage = $(this).closest(`.gform_page.details`);
        // Early return if not on visible details page
        if (!$detailsPage.length) return;

        // If preLeadData has data, skip the first click
        if (preLeadData && preLeadData.Status && detailsNextClickCount === 0) {
            detailsNextClickCount++;
            return;
        }
        detailsNextClickCount++;

        const $firstName = $detailsPage.find('.gfield.first_name input[type=text]').val();
        const $lastName = $detailsPage.find('.gfield.last_name input[type=text]').val();
        const $email = $detailsPage.find('.gfield.email input[type=email]').val();
        const $postCode = $(`form.${lhcFormClass} .gfield.postcode input[type=number]`).val();
        const $language = $detailsPage.find('.gfield.language input[type=text]').val();

        // Submit via AJAX
        $.ajax({
            url: (typeof lifeAjax !== 'undefined' && lifeAjax.ajaxurl) ? lifeAjax.ajaxurl : '/wp-admin/admin-ajax.php',
            type: 'POST',
            data: {
                action: 'life_update_lead_details',
                nonce: (typeof lifeAjax !== 'undefined' && lifeAjax.updateLeadDetailsNonce) ? lifeAjax.updateLeadDetailsNonce : '',
                email: $email,
                first_name: $firstName,
                last_name: $lastName,
                postcode: $postCode,
                language: $language
            },
            success: function (response) {
                if (response.success) {
                    // console.log('Lead inserted/updated successfully:', response);
                } else {
                    // Salesforce validation error or other error
                    console.error('Lead insertion failed:', response);
                    if (response.data && response.data.message) {
                        console.error('Error message:', response.data.message);
                    }
                    if (response.data && response.data.sf_errors) {
                        console.error('Salesforce errors:', response.data.sf_errors);
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', { xhr, status, error });
            }
        });

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
        const email = hcFormWrapper.find('#input-ausdrisk-user-email').val();
        const entryId = hcFormWrapper.find('#input-ausdrisk-entry-id').val();
        const phoneFieldId = hcFormWrapper.find('#input-ausdrisk-phone-gfield-id').val();
        const resultFieldId = hcFormWrapper.find('#input-ausdrisk-result-gfield-id').val();
        const ausdriskResult = hcFormWrapper.find('#input-ausdrisk-result').val();
        const comfortableEnglishVal = $form.find('input[name="comfortable_english"]:checked').val();

        console.log(comfortableEnglishVal);

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
        const $submitBtn = $form.find('#btn-submit-eoi');
        $phoneInput.prop('disabled', true);
        $submitBtn.prop('disabled', true).addClass('loading').val(submitLoadingText);
        $form.find('.choices-container').addClass('loading');
        $form.find('input[name="comfortable_english"]').prop('disabled', true);

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
                action: 'life_update_lead_eoi',
                nonce: (typeof lifeAjax !== 'undefined' && lifeAjax.updateLeadEOINonce) ? lifeAjax.updateLeadEOINonce : '',
                email: email,
                phone: phoneValue,
                entry_id: entryId,
                phone_field_id: phoneFieldId,
                result_field_id: resultFieldId,
                ausdrisk_result: ausdriskResult,
                comfortable_english: comfortableEnglishVal
            },
            success: function (response) {
                if (response.success) {
                    $form.remove();
                    let $thankYouMess = $('.hc-form-wrapper #thank-you');
                    $thankYouMess.slideDown(300, function () {
                        if ($thankYouMess.length) {
                            let containerOffset = $thankYouMess.offset().top;
                            let scrollTo = containerOffset - 100; // 100px offset from top
                            smoothScrollTo(Math.max(scrollTo, 0), 300);

                            trackEvent(`${trackingEventPrefix}_Thankyou`, {
                                form_id: lhcFormId,
                                language: trackingEventPrefix,
                                step: 'results'
                            });
                            // Add hash to URL
                            window.location.hash = 'thankyou';
                        }
                    });
                    $('.hc-form-wrapper .share-wrapper').show();
                } else {
                    $validateMess.text(response.data && response.data.message ? response.data.message : 'An error occurred. Please try again.').show();
                    $submitBtn.prop('disabled', false).removeClass('loading').val(submitButtonText);
                    $phoneInput.prop('disabled', false);
                    $form.find('.choices-container').removeClass('loading');
                    comfortableEnglishInput.prop('disabled', false);
                }
            },
            error: function (xhr, status, error) {
                $validateMess.text('An error occurred. Please try again.').show();
                $submitBtn.prop('disabled', false).removeClass('loading').val(submitButtonText);
                $phoneInput.prop('disabled', false);
                $form.find('.choices-container').removeClass('loading');
                comfortableEnglishInput.prop('disabled', false);
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
                    'confirm_contact',
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

            // Sync q11-mandatory-text style with q11 field
            this.syncQ11MandatoryTextStyle();

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

            // Listen for conditional logic changes (e.g., q12 appearing)
            $(document).on('gform_post_conditional_logic', (event, formId, fields, isInit) => {
                // Skip initialization phase as init() handles it
                if (isInit) return;

                let hcFormId = (typeof lifeHealthCheck !== 'undefined' && lifeHealthCheck.gravityFormId) ? lifeHealthCheck.gravityFormId : 2;
                // Check if the event is for our form
                if (parseInt(formId) !== parseInt(hcFormId)) return;

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

            this.syncQ11MandatoryTextStyle();

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
            // Sync q11-mandatory-text style after restoring field states
            this.syncQ11MandatoryTextStyle();
        }

        // Sync q11-mandatory-text opacity based on q11 disabled state
        syncQ11MandatoryTextStyle() {
            const $q11Field = this.form.find('.gfield.q11');
            const $q11MandatoryText = this.form.find('.gfield.q11-mandatory-text.gfield_html');

            if (!$q11Field.length || !$q11MandatoryText.length) return;

            // Check if q11 field has disabled-field class
            const isQ11Disabled = $q11Field.hasClass('disabled-field');

            // Set opacity based on q11's state
            if (isQ11Disabled) {
                $q11MandatoryText.css('opacity', '0.5');
            } else {
                $q11MandatoryText.css('opacity', '1');
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

            if (currWidth > 1024) {
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
