// Main Life Health Check functionality, rewritten to use jQuery document ready instead of IIFE pattern

jQuery(function($){
    'use strict';

    const lhcFormId = 2;
    const lhcFormClass = 'life-health-check-form';

    // Function to update radio button labels with first character
    function updateRadioButtonLabels() {
        $(`form.${lhcFormClass} .gfield_radio .gchoice label`).each(function() {            
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
        
        // Update heading text based on form state
        if (confirmationPage) {
            heading.text('Results');
        } else {
            // Check if intro step is completed
            const introStep = $(`#gf_step_${lhcFormId}_1`);
            if (introStep.length && introStep.hasClass('gf_step_completed')) {
                heading.text('Progress');
            } else {
                heading.text('Get started');
            }
        }
        
        $('.sidebar .progress-steps .progress-step').each(function() {            
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

    // Initial call when document is ready
    if ($('body').hasClass('life-health-check')) {
        updateRadioButtonLabels();
        updateSidebarProgressSteps();
    }

    // Update on Gravity Forms AJAX events
    $(document).on('gform_confirmation_loaded', function() {
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
        }
    });

    // Update on any AJAX form submission
    $(document).on('gform_post_render', function() {
        if ($('body').hasClass('life-health-check')) {
            updateRadioButtonLabels();
            updateSidebarProgressSteps();
            $(`form.${lhcFormClass}`).addClass('loading');
            setTimeout(function() {
                $(`form.${lhcFormClass}`).removeClass('loading');
            }, 300);            
        }
    });

    // Update when form is loaded via AJAX
    $(document).on('gform_load_form', function() {
        if ($('body').hasClass('life-health-check')) {
            updateRadioButtonLabels();
            updateSidebarProgressSteps();
            $(`form.${lhcFormClass}`).addClass('loading');
            setTimeout(function() {
                $(`form.${lhcFormClass}`).removeClass('loading');
                $(`header.top-nav`).addClass('hidden');
            }, 300);
        }
    });

    // Update on field validation
    $(document).on('gform_field_validation', function() {
        if ($('body').hasClass('life-health-check')) {
            updateRadioButtonLabels();
            updateSidebarProgressSteps();
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    // Add loading class for page navigation, scroll to form with 500px offset, smooth animation
    $(document).on('gform_page_loaded', function() {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
            // Animate scroll to the form, offset 220px, smooth
            let $formWrapper = $(`.life-health-check .form-wrapper`);
            if ($formWrapper.length) {
                $('html, body').animate({
                    scrollTop: Math.max($formWrapper.offset().top - 220, 0)
                }, 400, 'swing');
            }
            setTimeout(function() {
                $(`form.${lhcFormClass}`).removeClass('loading');
            }, 300);
        }
    });

    // Add loading class for form submission
    $(document).on('gform_ajax_submit', function() {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    // Remove loading class on validation errors
    $(document).on('gform_validation_errors', function() {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).removeClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    // Add loading class when clicking next/previous buttons
    $(document).on('click', '.gform_next_button, .gform_previous_button', function() {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });

    // Add loading class when submitting form
    $(document).on('submit', '.life-health-check', function() {
        if ($('body').hasClass('life-health-check')) {
            $(`form.${lhcFormClass}`).addClass('loading');
            $(`header.top-nav`).addClass('hidden');
        }
    });


    // On change event for postcode field in .life-health-check-form
    $(document).on('change input blur', `form.${lhcFormClass} .gfield.postcode input[type=number]`, function() {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $input = $(this);
        let currentPage = $input.closest('.gform_page');
        let parentField = $input.closest('.gfield');
        let nextButton = currentPage.find('.gform_next_button');
        let value = $.trim($input.val());
        
        // Get non-Victorian postcodes from hidden input
        let nonVicPostcodes = [];
        const nonVicInput = $('#non_vic_postcodes_json');
        if (nonVicInput.length && nonVicInput.val()) {
            try {
                nonVicPostcodes = JSON.parse(nonVicInput.val());
            } catch (e) {
                console.warn('Invalid JSON in non_vic_postcodes_json:', e);
            }
        }        
        
        // Check if postcode is valid Australian postcode (4 digits)
        let isValidFormat = /^[0-9]{4}$/.test(value);
        // Check if postcode is Victorian (3000-3999 and 8000-8999) or in acceptable non-Victorian list
        let isVicPostcode = /^(3[0-9]{3}|8[0-9]{3})$/.test(value);
        let isAcceptableNonVic = nonVicPostcodes.includes(value);
        
        let valid = isValidFormat && (isVicPostcode || isAcceptableNonVic);
        
            if (!valid) {
                setTimeout(function() {
                    parentField.addClass('gfield_error is_invalid').removeClass('is_valid');
                    nextButton.prop('disabled', true);
                    // Prevent multiple validation messages
                    if (parentField.find('.validation_message').length === 0) {
                        parentField.append('<div class="gfield_description validation_message gfield_validation_message">Please enter a valid Victoria postcode.</div>');
                    }
                }, 600);
            } else {
                setTimeout(function() {
                    nextButton.prop('disabled', false);
                    parentField.removeClass('gfield_error is_invalid').addClass('is_valid');
                    parentField.find('.validation_message').remove();
                }, 1000);
            }
        
    });

    // On change event for name field in .life-health-check-form
    $(document).on('change input blur', `form.${lhcFormClass} .gfield.name input[type=text]`, function() {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $input = $(this);
        let currentPage = $input.closest('.gform_page');
        let parentField = $input.closest('.gfield');
        let nextButton = currentPage.find('.gform_next_button');
        let value = $.trim($input.val());
        setTimeout(function() {
            if (!value || value.trim().length === 0) {
                parentField.addClass('gfield_error is_invalid').removeClass('is_valid');
                nextButton.prop('disabled', true);
                // Prevent multiple validation messages
                if (parentField.find('.validation_message').length === 0) {
                    parentField.append('<div class="gfield_description validation_message gfield_validation_message">Please enter your full name.</div>');
                }
            } else {
                nextButton.prop('disabled', false);
                parentField.removeClass('gfield_error is_invalid').addClass('is_valid').find('.validation_message').remove();
            }
        }, 1000);
    });

    // On change event for email field in .life-health-check-form with email validation
    $(document).on('change input blur', `form.${lhcFormClass} .gfield.email input[type=email]`, function() {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $input = $(this);
        let currentPage = $input.closest('.gform_page');
        let parentField = $input.closest('.gfield');
        let nextButton = currentPage.find('.gform_next_button');
        let value = $.trim($input.val());
        // Basic email validation regex
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        let isEmailValid = emailPattern.test(value);
        setTimeout(function() {
            if (!value || value.trim().length === 0 || !isEmailValid) {
                parentField.addClass('gfield_error is_invalid').removeClass('is_valid');
                nextButton.prop('disabled', true);
                // Prevent multiple validation messages
                if (parentField.find('.validation_message').length === 0) {
                    parentField.append('<div class="gfield_description validation_message gfield_validation_message">Please enter a valid email address e.g name@email.com</div>');
                }
            } else {
                nextButton.prop('disabled', false);
                parentField.removeClass('gfield_error is_invalid').addClass('is_valid').find('.validation_message').remove();
            }
        }, 1000);
    });

    // On change event for select field in .life-health-check-form with email validation
    $(document).on('change', `form.${lhcFormClass} .gfield select.gfield_select`, function() {
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
                parentField.append('<div class="gfield_description validation_message gfield_validation_message">Please choose an option.</div>');
            }
        } else {
            nextButton.prop('disabled', false);
            parentField.removeClass('gfield_error is_invalid').addClass('is_valid').find('.validation_message').remove();
            parentField.find('.ginput_container_select').append(btnClear);
        }
    });

    // On change event for checkbox fields to handle "None of the below" logic
    $(document).on('change input', `form.${lhcFormClass} .gfield_checkbox input[type=checkbox]`, function() {
        if (!$(this).closest('.gfield').hasClass('gfield_contains_required')) {
            return;
        }
        let $changed = $(this);
        let parentField = $changed.closest('.gfield');
        let $checkboxes = parentField.find('input[type=checkbox]');
        
        // Find the "None of the below" checkbox (case-insensitive)
        let $noneCheckbox = $checkboxes.filter(function() {
            return $.trim($(this).val()).toLowerCase() === 'none';
        });

        if ($changed.prop('checked')) {
            if ($changed.is($noneCheckbox)) {
                // If "None of the below" is checked, uncheck all others
                $checkboxes.not($noneCheckbox).each(function() {
                    if ($(this).prop('checked')) {
                        $(this).prop('checked', false).trigger('change');
                    }
                });
            } else {
                // If any box other than "None of the below" is checked, uncheck "None of the below"
                $noneCheckbox.prop('checked', false);
            }
        }
    });

    $(document).on('click', '.gfield .btn-clear-select', function() {
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

    // Enhanced listener for analytics/hash update on field changes
    $(document).on('change input', '.gfield input, .gfield select', function () {
        const $input = $(this);
        const $parentField = $input.closest('.gfield');
        const $currentPage = $input.closest('.gform_page');

        // Improved: Get section and field name dynamically
        const sectionMap = ['intro', 'details'];
        let sectionName = 'questions';
        for (let section of sectionMap) {
            if ($currentPage.hasClass(section)) {
                sectionName = section;
                break;
            }
        }

        // Improved: Identify field name by matching class with prefix or full list (scalable for new questions)
        const knownFields = [
            'diabetes', 'postcode', 'name', 'email',
            'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12'
        ];
        let fieldName = 'question';
        for (let key of knownFields) {
            if ($parentField.hasClass(key)) {
                fieldName = key;
                break;
            }
        }

        // Check if field is text, number, or email type
        const inputType = $input.attr('type') || '';
        const isTextNumberEmail = ['text', 'number', 'email'].includes(inputType.toLowerCase());
        
        // For text, number, email fields: check validation class instead of hashing value
        let value;
        if (isTextNumberEmail) {
            // Check validation class from other validation function
            if ($parentField.hasClass('is_valid')) {
                value = 'valid';
            } else if ($parentField.hasClass('is_invalid')) {
                value = 'invalid';
            }
        } else {
            // For other fields (radio, select, etc.): use actual value
            value = ($input.val() || '').toString().trim().toLowerCase().replace(/\s+/g, '-');
        }

        // Only proceed if fieldName is meaningful or value exists
        if (fieldName && value !== undefined) {
            // Set new hash fragment (prevents duplicate hash if same as before)
            let newHash = `${sectionName}:${fieldName}-${value}`;
            if (window.location.hash !== `#${newHash}`) {
                window.location.hash = newHash;
            }

            // Send event to GA4 only if window.dataLayer is present
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: `${fieldName}_${value}`,
                field: fieldName,
                value: value,
                section: sectionName,
            });
        }
    });

}); // end main jQuery ready

// Gravity Forms Progressive Field Reveal (jQuery)
jQuery(function($){
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
            this.validFields = currentPage.find('.gfield').filter(function() {
                const $field = $(this);
                const fieldClass = $field.attr('class') || '';
                
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
                    'name',
                    'mail'
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
                    }
                }, 100);
            });

            $(document).on('gform_page_loaded', () => {
                setTimeout(() => {
                    this.setupProgressiveReveal();
                }, 100);
            });
        }

        // Handle field change and validation
        handleFieldChange($field) {
            if (this.isFieldValid($field)) {
                this.revealNextField($field);
                this.updatePageFooterState();
            }
        }

        // Check if field is valid
        isFieldValid($field) {
            const $inputs = $field.find('input, select, textarea');
            
            // Check each input in the field
            let isValid = true;
            $inputs.each((index, input) => {
                const $input = $(input);
                const inputType = $input.attr('type') || input.tagName.toLowerCase();
                
                if (inputType === 'radio') {
                    // For radio groups, check if any in the group is selected
                    const radioName = $input.attr('name');
                    const radioGroup = $field.find(`input[name="${radioName}"]`);
                    isValid = isValid && radioGroup.filter(':checked').length > 0;
                } else if (inputType === 'checkbox') {
                    // For checkboxes, check if any in the group is selected
                    const checkboxGroup = $field.find('input[type="checkbox"]');
                    isValid = isValid && checkboxGroup.filter(':checked').length > 0;
                } else if (inputType === 'select') {
                    // For selects, check if value is not empty
                    isValid = isValid && $input.val() !== '' && $input.val() !== null;
                } else {
                    // For text inputs, check if value is not empty
                    isValid = isValid && $input.val().trim() !== '';
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
                
                // Remove disabled class and add active class with animation
                $nextField.removeClass('disabled-field').addClass('active-field');
                
                // Trigger fade-in animation
                $nextField.fadeIn(200);
            }
        }

        // Update page footer button states based on field completion
        updatePageFooterState() {
            const currentPage = this.form.find('.gform_page:visible');
            const pageFooter = currentPage.find('.gform_page_footer');
            
            if (!pageFooter.length) return;
            
            // Check if all fields on current page are completed
            let allFieldsCompleted = true;
            this.validFields.each((index, field) => {
                const $field = $(field);
                if (!$field.hasClass('completed-field') && !this.isFieldValid($field)) {
                    allFieldsCompleted = false;
                    return false; // break the loop
                }
            });
            
            // Get all buttons in page footer
            const buttons = pageFooter.find('input[type="submit"], .gform_next_button, .gform_previous_button');
            
            buttons.each(function() {
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

}); // end jQuery ready

