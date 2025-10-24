<!-- <div id="pcos-form-modal">
  <div class="-window">
    <div class="dismiss-modal">
      <button
        type="button"
        class="icon"
        data-dismiss-modal
        aria-label="Dismiss modal"
      ><?php echo life_icon('times') ?></button>
    </div>
    <h2>Register for the <i>Life!</i> program</h2>
    <h3
      class="font-middling wt-sb lh-tight"
    >Submit your details and we will get back to you shortly.</h3>
    <form
      id="health-check-contact"
      action="/"
      method="post"
      class="screening-email"
    >
      <div class="columned-group">
        <div class="column">
          <div class="form-group">
            <label for="send-contact-first-name">First name</label>
            <input
              id="send-contact-first-name"
              type="text"
              name="first_name"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                value="PCOS Test <?= date('m_d_h_i_s') ?>"
              <?php endif ?>
              required
              data-parsley-error-message="This value is required."
            />
          </div>
        </div>
        <div class="column">
          <div class="form-group">
            <label for="send-contact-last-name">Last name</label>
            <input
              id="send-contact-last-name"
              type="text"
              name="last_name"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                value="BrightLabs Lee"
              <?php endif ?>
              required
              data-parsley-error-message="This value is required."
            />
          </div>
        </div>
      </div>
      <div class="columned-group">
        <div class="column">
          <div class="form-group">
            <label for="send-contact-phone">Mobile</label>
            <input
              id="send-contact-phone"
              type="tel"
              name="phone"
              title="Enter 10 digit phone number without spaces"
              data-parsley-type="number"
              data-parsley-maxlength="10"
              data-parsley-minlength="10"
              data-parsley-type-message="Invalid value. Please use numbers only"
              data-parsley-maxlength-message="This value is too long. It should have 10 characters."
              data-parsley-minlength-message="This value is too short. It should have 10 characters."
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                value="0415419771"
              <?php endif ?>
              required
              data-parsley-error-message="Invalid value. Please use number only."
            />
          </div>
        </div>
        <div class="column">
          <div class="form-group">
            <label for="send-contact-email">Email</label>
            <input
              id="send-contact-email"
              type="email"
              name="email"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                value="lee+<?= date('m_d_h_i_s') ?>@brightlabs.com.au"
              <?php endif ?>
              required
              data-parsley-error-message="This should be a valid email."
            />
          </div>
        </div>
      </div>
      <div class="form-group" style="margin-bottom: 14px">
        <label>Are you currently living with Polycystic Ovary Syndrome?</label>
        <div class="block-radio-group thirds">
          <div class="block-radio">
              <label class="option label">
                  <input type="radio" name="living_with_pcos" value="Yes">
                  <span class="option-label">
                      <span>Yes</span>
                  </span>
              </label>
          </div>
          <div class="block-radio">
              <label class="option label">
                  <input type="radio" name="living_with_pcos" value="No">
                  <span class="option-label">
                      <span>No</span>
                  </span>
              </label>
          </div>
        </div>
      </div>
      <div class="columned-group">
        <div class="column">
          <div class="form-group">
            <label for="send-contact-via">How did you hear about us?</label>
            <select id="send-contact-via" name="heard_about_via">
              <option value="">Please select...</option>
              <option value="Monash PCOS Clinic">Monash PCOS Clinic</option>
              <option value="GP">GP</option>
              <option
                value="Other"
                <?php if (AUTOFILL_CONTACT_FORM): ?>
                  selected
                <?php endif ?>
              >Other</option>
            </select>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="type-checkbox">
          <label class="option label">
            <input
              type="checkbox"
              name="consent"
              value="yes"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                checked
              <?php endif ?>
            />
            <span class="option-label">I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to contact me regarding the <em>Life!</em> program and for any personal information collected to be used for necessary <em>Life!</em> program administrative operations.</span>
            <?php echo life_icon('check') ?>
          </label>
        </div>
      </div>
      <div class="form-group">
        <div class="type-checkbox">
          <label class="option label">
            <input
              type="checkbox"
              name="consent_refer"
              value="yes"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                checked
              <?php endif ?>
            />
            <span class="option-label">I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to provide information such as enrolment status back to referring agency e.g. Monash PCOS Clinic.</span>
            <?php echo life_icon('check') ?>
          </label>
        </div>
      </div>

      <div class="form-feedback"></div>

      <div class="form-group close-modal">
        <button
          type="button"
          name="submit_signup"
          class="button grey"
          data-refresh-page
          aria-label="Return to site"
        >
          <span>Return to Site.</span>
        </button>
      </div>
      <div class="form-group submit">
        <button
          type="submit"
          name="send_enquiry"
          class="button grey loader"
          aria-label="Submit details"
        >
          <?php echo life_icon('loader', null, 'life-spin loading') ?>
          <span>Submit Details</span>
        </button>
        <input type="hidden" name="action" value="life_ajax_submit_form"/>
        <input type="hidden" name="form_id" value="pcos"/>
        <input type="hidden" name="language" value="english"/>
      </div>
    </form>
  </div>
</div> -->