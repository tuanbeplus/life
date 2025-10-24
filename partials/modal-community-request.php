
<div id="community-request-modal" class="modal uses-simplebar" data-dismissable="1">
  <div class="inner">
    <div class="content formatted">
      <h2 class="modal-heading">Request a Community Session</h2>
      <form action="/" method="post" novalidate="" data-ajax-submit>
        <div class="form-group">
          <label for="community-name">Name of organisation or community group</label>
          <input type="text" name="company" value="" id="community-name" aria-required="true" required />
        </div>
        <div class="form-group">
          <label for="community-first-name">Contact person first name</label>
          <input type="text" name="first_name" value="" id="community-first-name" aria-required="true" required />
        </div>
        <div class="form-group">
          <label for="community-last-name">Contact person last name</label>
          <input type="text" name="last_name" value="" id="community-last-name" aria-required="true" required />
        </div>
        <div class="form-group">
          <label for="community-heard-about-via">How did you hear about the <em>Life!</em> program?</label>
          <input type="text" name="heard_about_via" value="" id="community-heard-about-via" aria-required="true" required />
        </div>
        <div class="form-group">
          <label for="community-phone">Phone</label>
          <input type="text" name="phone" value="" id="community-phone" aria-required="true" required />
        </div>
        <div class="form-group">
          <label for="community-email">Email</label>
          <input type="email" name="email" value="" id="community-email" aria-required="true" required />
        </div>
        <div class="form-group">
          <label for="community-session-dates">Proposed session dates - please provide at least two dates</label>
          <input type="text" name="session_dates" value="" id="community-session-dates" aria-required="true" required />
        </div>
        <div class="form-group">
          <label for="community-participants">Number of participants</label>
          <input type="number" name="participants" value="" id="community-participants" aria-required="true" required data-parsley-required-message="Please enter the number of participants" />
        </div>
        <?php /* <div class="form-group">
          <label for="community-session-type">Would you like a face-to-face session or a webinar? </label>
          <select name="session_type" id="community-session-type" aria-required="true" required>
            <option value="">Please select...</option>
            <option value="Face-to-face session">Face-to-face session</option>
            <option value="Webinar">Webinar</option>
          </select>
        </div> */ ?>
        <div class="form-feedback"></div>
        <div class="form-group close-modal">
          <button type="button" name="submit_signup" class="button grey" data-dismiss-modal aria-label="Return to site"><span>Return to Site</span></button>
        </div>
        <div class="form-group submit">
          <button type="submit" name="submit_signup" class="button grey loader" aria-label="Submit enquiry">
            <?php echo life_icon('loader', null, 'life-spin loading'); ?>
            <span>Submit Enquiry</span>
          </button>
          <input type="hidden" name="action" value="life_ajax_submit_form" />
          <input type="hidden" name="form_id" value="communityRequest" />
        </div>
      </form>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.inner -->
  <div class="dismiss-modal">
    <button type="button" class="icon" data-dismiss-modal aria-label="Close modal"><?php echo life_icon('times'); ?></button>
  </div>
</div>
<!-- /#health-check-modal -->
