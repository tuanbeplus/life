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
      <ajax-form
        form-id="contact"
        :fields="<?= vueProp([
          [
            'type' => 'text',
            'label' => 'First name',
            'name' => 'first_name',
            'val' => AUTOFILL_CONTACT_FORM ? 'Lee' : '',
          ],
          [
            'type' => 'text',
            'label' => 'Last name',
            'name' => 'last_name',
            'val' => AUTOFILL_CONTACT_FORM ? 'Bright Labs' : '',
          ],
          [
            'type' => 'email',
            'label' => 'Email',
            'name' => 'email',
            'val' => AUTOFILL_CONTACT_FORM ? 'lee@brightlabs.com.au' : '',
          ],
          [
            'type' => 'text',
            'label' => 'Phone',
            'name' => 'phone',
            'val' => AUTOFILL_CONTACT_FORM ? '1234567890' : '',
          ],
          [
            'type' => 'select',
            'label' => 'Preferred method of contact',
            'name' => 'contact_method',
            'opts' => selectOpts(['Email', 'Phone'], false, 'Please select...'),
            'val' => AUTOFILL_CONTACT_FORM ? 'Email' : '',
          ],
          [
            'type' => 'select',
            'label' => 'Are you comfortable speaking English?',
            'name' => 'speaks_english',
            'opts' => selectOpts(['Yes', 'No'], false, 'Please select...'),
            'val' => AUTOFILL_CONTACT_FORM ? 'Yes' : '',
          ],
          [
            'type' => 'text',
            'label' => 'Language spoken at home (if not English)',
            'name' => 'home_language',
            'required' => false,
            'val' => '',
          ],
          [
            'type' => 'textarea',
            'label' => 'Message',
            'name' => 'contact_message',
            'val' => AUTOFILL_CONTACT_FORM ? 'Brightlabs salesforce test' : '',
          ],
        ]) ?>"
      ></ajax-form>
    </div>
  </div>
</section>
