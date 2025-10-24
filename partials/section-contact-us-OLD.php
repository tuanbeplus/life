<?php
// $languages = include get_template_directory() . '/inc/lang/contact-form-langs.php';
?>
<section class="section-contact-us bg-white">
  <div class="center-frame">
    <div class="sidebar">
      <h3 class="font-lgr wt-bold lh-tight">Get in touch</h3>
      <p class="font-sm lh-loose">If you have an enquiry, please complete and submit the enquiry form here and the
        <em>Life!</em> team will get back to you shortly.</p>
        <hr/>
      <p class="font-sm lh-std">Get in touch with our helpful team today on our infoline:</p>
      <ul class="contact-numbers wt-sb">
        <li><a href="tel:137475" class="fg-primary risk-13-wcag">13 RISK</a></li>
        <li><a href="tel:137475" class="fg-near-black">13 74 75</a></li>
      </ul>
      <hr class="mobile-only tablet-only block"/>
    </div>
    <div class="formatted main-content">
      <?= apply_filters('the_content', get_the_content()) ?>
      <form
        action="/"
        method="post"
      >
        <div class="form-group">
          <label for="contact-first-name">First name</label>
          <input
            type="text"
            name="first_name"
            value="<?= AUTOFILL_CONTACT_FORM ? 'Lee' : '' ?>"
            id="contact-first-name"
            aria-required="true"
            required
          />
        </div>
        <div class="form-group">
          <label for="contact-last-name">Last name</label>
          <input
            type="text"
            name="last_name"
            value="<?= AUTOFILL_CONTACT_FORM ? 'Bright Labs' : '' ?>"
            id="contact-last-name"
            aria-required="true"
            required
          />
        </div>
        <div class="form-group">
          <label for="contact-email">Email</label>
          <input
            type="email"
            name="email"
            value="<?= AUTOFILL_CONTACT_FORM ? 'lee@brightlabs.com.au' : '' ?>"
            id="contact-email"
            aria-required="true"
            required
          />
        </div>
        <div class="form-group">
          <label for="contact-phone">Phone</label>
          <input
            type="text"
            name="phone"
            value="<?= AUTOFILL_CONTACT_FORM ? '1234567890' : '' ?>"
            id="contact-phone"
            aria-required="true"
            required
          >
        </div>
        <div class="form-group">
          <label for="contact-method">Preferred method of contact</label>
          <select-sml
            :opts="<?= vueProp(selectOpts(['Email', 'Phone'], false, 'Please select...')) ?>"
            init-key="<?= AUTOFILL_CONTACT_FORM ? 'Email' : '' ?>"
            fieldname="contact_method"
          ></select-sml>
        </div>
        <div class="form-group">
          <label for="contact-english">Are you comfortable speaking English?</label>
          <select-sml
            :opts="<?= vueProp(selectOpts(['Yes', 'No'], false, 'Please select...')) ?>"
            init-key="<?= AUTOFILL_CONTACT_FORM ? 'Yes' : '' ?>"
            fieldname="speaks_english"
          ></select-sml>
        </div>
        <div class="form-group">
          <label for="contact-language">Language spoken at home (if not English)</label>
          <input
            type="text"
            name="home_language"
            value=""
            id="contact-language"
          />
        </div>
        <div class="form-group">
          <label for="contact-message">Message</label>
          <textarea
            name="contact_message"
            cols="40"
            rows="10"
            id="contact-message"
            aria-required="true"
            required
          ><?= AUTOFILL_CONTACT_FORM ? 'Brightlabs salesforce test' : '' ?></textarea>
        </div>
        <div class="form-feedback"></div>
        <div class="form-group submit">
          <button
            type="submit"
            name="submit_signup"
            class="button grey loader"
            aria-label="Submit enquiry"
          >
            <?= life_icon('loader', null, 'life-spin loading') ?>
            <span>Submit Enquiry</span>
          </button>
          <input type="hidden" name="action" value="life_ajax_submit_form"/>
          <input type="hidden" name="form_id" value="contact"/>
        </div>
      </form>
    </div>
  </div>
</section>
<!-- /.content -->
