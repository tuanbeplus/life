<div class="tab-inner contact " data-tab-number="contact" data-tab-set="health-check">
    <div class="inner">

        <h2 class="modal-heading">You're only one step away</span></h2>
        <h3 class="font-middling wt-sb lh-tight">Submit your details and we will get back to you
            shortly.</h3>

        <form id="health-check-contact" action="/" method="post" class="screening-email"
                data-parsley-trigger="input change" data-ajax-submit>
            <div class="columned-group">
                <div class="column">
                    <div class="form-group">
                        <label for="send-contact-first-name">First name</label>
                        <input value="Bright Labs" id="send-contact-first-name" type="text" name="first_name" required/>
                    </div>
                </div>

                <div class="column">
                    <div class="form-group">
                        <label for="send-contact-last-name">Last name</label>
                        <input value="Test <?= date('H:i:s') ?>" id="send-contact-last-name" type="text" name="last_name" required/>
                    </div>
                </div>
            </div>

            <div class="columned-group">
                <div class="column">
                    <div class="form-group">
                        <label for="send-contact-email">Email</label>
                        <input value="lee+<?= date('m_d_h_i_s') ?>@brightlabs.com.au" id="send-contact-email" type="email" name="email" required/>
                    </div>
                </div>
                <div class="column">
                    <div class="form-group">
                        <label for="send-contact-phone">
                            <span data-only-moderate-risk>Mobile </span>Phone
                        </label>
                        <input
                            id="send-contact-phone" value="0415419123"
                            type="tel"
                            name="phone"
                            title="Enter 10 digit phone number without spaces"
                            data-parsley-type="number"
                            data-parsley-maxlength="10"
                            data-parsley-minlength="10"
                            data-parsley-type-message="Invalid value. Please use numbers only."
                            data-parsley-maxlength-message="This value is too long. It should have 10 characters."
                            data-parsley-minlength-message="This value is too short. It should have 10 characters."
                            required
                        />
                    </div>
                </div>
            </div>

            <div class="columned-group">
                <div class="column">
                    <div class="form-group">
                        <label for="send-contact-postcode">Postcode</label>
                        <input value="3057" id="send-contact-postcode" type="text" name="postcode" required/>
                    </div>
                </div>
                <div class="column">
                    <div class="form-group">
                        <label for="send-contact-via">How did you first hear about us?</label>

                        <select id="send-contact-via" name="heard_about_via">
                        <option value="">Please select...</option>
                            <option value="A friend or family member">A friend or family member</option>
                            <?php if (FIT_BIT_COMPETITION): ?>
                                <option value="Fit Bit Competition">Fit Bit Competition</option>
                            <?php endif ?>
                            <option value="Community Group">Community Group</option>
                            <option selected value="Event">Event</option>
                            <option value="Health Professional">Health Professional</option>
                            <option value="GP">GP</option>
                            <option value="Word of mouth">Word of mouth</option>
                            <option value="Workplace">Workplace</option>
                            <option value="Google search">Google search</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group hidden" data-conditional-field="health_professional">
                <label for="health_professional">Name of the health professional (optional)</label>
                <input
                    id="health_professional"
                    type="text"
                    name="health_professional"
                    placeholder="Health professional"
                />
            </div>

            <div
                class="form-group hidden mt-25"
                data-conditional-field="workplace"
            >
                <label for="workplace">Name of workplace (optional)</label>
                <input
                    id="workplace"
                    type="text"
                    name="workplace"
                    placeholder="Workplace"
                />
            </div>

            <!-- <div class="form-group" data-only-moderate-risk>
                <label for="send-contact-time">What is the best way to contact you?</label>

                <select id="send-contact-time" name="contact_time">
                    <option value="">Please select...</option>
                    <option value="email">Email</option>
                    <option value="text">Text message</option>
                </select>
            </div> -->

            <div class="form-group">
                <div class="type-checkbox">
                    <label class="option label">
                        <input type="checkbox" name="consent" value="yes" checked />
                        <span class="option-label">I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to contact me regarding the <em>Life!</em> program and for any personal information collected to be used for necessary <em>Life!</em> program administrative operations.</span>
                        <?php echo life_icon('check'); ?>
                    </label>
                </div>
            </div>

            <div class="form-feedback"></div>

            <div class="form-group close-modal">
                <button type="button" name="submit_signup" class="button grey" data-dismiss-modal
                        aria-label="Return to site"><span>Return to Site</span></button>
            </div>

            <div class="form-group submit">
                <button
                    type="submit"
                    name="send_enquiry"
                    class="button grey loader"
                    aria-label="Submit details"
                >
                    <?php echo life_icon('loader', null, 'life-spin loading'); ?>
                    <span>Submit Details</span>
                </button>
                <?php if ($now >= $oooDateStart && $now <= $oooDateEnd): ?>
                    <div class="alert" style="margin-top:20px;">
                        <p>
                            Please note, the Life! program will be closed between 17/12 – 04/01.<br/>
                            Rest assured your enquiry has been received and will be responded to upon
                            our return.
                        </p>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="action" value="life_ajax_submit_form"/>
                <input type="hidden" name="form_id" value="ausdrisk"/>
                <input type="hidden" name="language" value="english"/>
                <input type="hidden" name="risk_score" value=""/>
                <input type="hidden" name="age" value=""/>
                <input type="hidden" name="background" value=""/>
                <input type="hidden" name="birthplace" value=""/>
                <input type="hidden" name="diabetes" value=""/>
                <input type="hidden" name="pregnancy" value=""/>
                <input type="hidden" name="blood_pressure_medication" value=""/>
                <input type="hidden" name="smoker" value=""/>
                <input type="hidden" name="vegetables" value=""/>
                <input type="hidden" name="exercise" value=""/>
                <input type="hidden" name="waist_atsi" value=""/>
                <input type="hidden" name="waist_other" value=""/>
                <input type="hidden" name="gender" value="" class="gender-selection-modal-health-check"/>
                <div class="extra-fields"></div>
            </div>

        </form>

    </div>
</div>