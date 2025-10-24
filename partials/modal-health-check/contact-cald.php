<form
  id="health-check-<?= $lang ?>-contact"
  action="/"
  method="post"
  class="screening-email"
  data-parsley-trigger="input change"
  data-ajax-submit
>
  <div class="columned-group">

    <?php if ($first_name = ($fields['first_name'] ?? null)): ?>
      <div class="column">
        <div class="form-group">
          <label for="send-contact-first-name-<?= $lang ?>"><?= $first_name['label'] ?></label>
          <input
            id="send-contact-first-name-<?= $lang ?>"
            type="text"
            name="first_name"
            data-parsley-required-message="<?= $parsley_message_generic_required ?>"
            required
          />
        </div>
      </div>
    <?php elseif (WP_DEBUG): ?>
      <p>missing first_name field</p>
    <?php endif ?>

    <?php if ($last_name = ($fields['last_name'] ?? null)): ?>
      <div class="column">
        <div class="form-group">
          <label for="send-contact-last-name-<?= $lang ?>"><?= $last_name['label'] ?></label>
          <input
            id="send-contact-last-name-<?= $lang ?>"
            type="text"
            name="last_name"
            data-parsley-required-message="<?= $parsley_message_generic_required ?>"
            required
          />
        </div>
      </div>
    <?php elseif (WP_DEBUG): ?>
      <p>missing last_name field</p>
    <?php endif ?>

  </div>
  <div class="columned-group">

    <?php if ($phone = ($fields['phone'] ?? null)): ?>
      <div class="column">
        <div class="form-group">
          <label for="send-contact-phone-<?= $lang ?>"><?= $phone['label'] ?></label>
          <input
            id="send-contact-phone-<?= $lang ?>"
            type="tel"
            name="phone"
            title="<?= $phone['title'] ?>"
            data-parsley-type="number"
            data-parsley-maxlength="10"
            data-parsley-minlength="10"
            maxlength="10"
            <?php foreach ($phone['parsley'] as $key => $message): ?>
              data-parsley-<?= $key ?>-message="<?= $message ?>"
            <?php endforeach ?>
            required
          />
        </div>
      </div>
    <?php elseif (WP_DEBUG): ?>
      <p>missing phone field</p>
    <?php endif ?>

    <?php if ($postcode = ($fields['postcode'] ?? null)): ?>
      <div class="column">
        <div class="form-group">
          <label for="send-contact-postcode-<?= $lang ?>"><?= $postcode['label'] ?></label>
          <input
            id="send-contact-postcode-<?= $lang ?>"
            type="text"
            name="postcode"
            title="<?= $postcode['title'] ?>"
            data-parsley-type="number"
            data-parsley-maxlength="4"
            data-parsley-minlength="4"
            maxlength="4"
            <?php foreach ($postcode['parsley'] as $key => $message): ?>
              data-parsley-<?= $key ?>-message="<?= $message ?>"
            <?php endforeach ?>
            required
          />
        </div>
      </div>
    <?php elseif (WP_DEBUG): ?>
      <p>missing postcode field</p>
    <?php endif ?>

  </div>

  <?php if ($email = ($fields['email'] ?? null)): ?>
    <div class="form-group">
      <label for="send-contact-email-<?= $lang ?>"><?= $email['label'] ?></label>
      <input
        id="send-contact-email-<?= $lang ?>"
        type="email"
        name="email"
        data-parsley-required-message="<?= $parsley_message_generic_required ?>"
        data-parsley-type-message="<?= $email['parsley_type_message'] ?>"
        required
      />
    </div>
  <?php elseif (WP_DEBUG): ?>
    <p>missing email field</p>
  <?php endif ?>


  <?php if ($heard_about_via = ($fields['heard_about_via'] ?? null)): ?>
    <div class="form-group">
      <label for="send-contact-via-<?= $lang ?>"><?= $heard_about_via['label'] ?></label>
      <select id="send-contact-via-<?= $lang ?>" name="heard_about_via">
        <?php foreach ($heard_about_via['options'] as $value => $label): ?>
          <option value="<?= $value ?>"><?= $label ?></option>
        <?php endforeach ?>
      </select>
    </div>
  <?php elseif (WP_DEBUG): ?>
    <p>missing heard_about_via field</p>
  <?php endif ?>
  <?php if ($speaks_english = ($fields['speaks_english'] ?? null)): ?>
    <div class="form-group">
      <div class="type-checkbox">
        <label class="option label">
          <input type="checkbox" name="speaks_english" value="yes">
          <span class="option-label"><?= $speaks_english['label'] ?></span>
          <?php echo life_icon('check'); ?>
        </label>
      </div>
    </div>
  <?php elseif (WP_DEBUG): ?>
    <p>missing speaks_english field</p>
  <?php endif ?>
  <?php if ($consent = ($fields['consent'] ?? null)): ?>
    <div class="form-group">
      <div class="type-checkbox">
        <label class="option label">
          <input type="checkbox" name="consent" value="yes">
          <span class="option-label"><?= $consent['label'] ?></span>
          <?php echo life_icon('check'); ?>
        </label>
      </div>
    </div>
  <?php elseif (WP_DEBUG): ?>
    <p>missing consent field</p>
  <?php endif ?>

  <div class="form-feedback"></div>

  <div class="form-group close-modal">
    <button
      type="button"
      name="submit_signup"
      class="button grey"
      data-dismiss-modal
      aria-label="Return to site"
    >
      <span><?= $return_to_site_button_text ?></span>
    </button>
  </div>
  <div class="form-group submit">
    <button
      type="submit"
      name="send_enquiry"
      class="button grey loader"
      aria-label="Submit details"
    >
      <?php echo life_icon('loader', null, 'life-spin loading'); ?>
      <span class="tracking-button-submit-vi"><?= $submit_button_text ?></span>
    </button>
    <input type="hidden" name="action" value="life_ajax_submit_form"/>
    <input type="hidden" name="form_id" value="ausdrisk"/>
    <input type="hidden" name="language" value="<?= $lang ?>"/>
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
  </div>
</form>
