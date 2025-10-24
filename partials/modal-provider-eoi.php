
<div id="provider-eoi-modal" class="modal uses-simplebar" data-dismissable="1">
  <div class="inner">
    <div class="content formatted">
      <h2 class="modal-heading">Become a <em>Life!</em> Program Provider</h2>
      <form action="/" method="post" novalidate="" data-ajax-submit>
        <h4 class="modal-subheading font-md wt-sb">Organisation Details</h4>
        <div class="form-group">
          <label for="provider-org-name">Organisation Name</label>
          <input type="text" name="org_name" value="" id="provider-org-name" required />
        </div>
        <div class="form-group">
          <label for="provider-building">Building Name</label>
          <input type="text" name="building" value="" id="provider-building" />
        </div>
        <div class="columned-group">
          <div class="column">
            <div class="form-group">
              <label for="provider-address">Street address</label>
              <input type="text" name="address" value="" id="provider-address" required />
            </div>
          </div>
          <div class="column">
            <div class="form-group">
              <label for="provider-suburb">Suburb</label>
              <input type="text" name="suburb" value="" id="provider-suburb" required />
            </div>
          </div>
        </div>
        <div class="columned-group">
          <div class="column">
            <div class="form-group">
              <label for="provider-state">State</label>
              <input type="text" name="state" value="" id="provider-state" required />
            </div>
          </div>
          <div class="column">
            <div class="form-group">
              <label for="provider-postcode">Postcode</label>
              <input type="text" name="postcode" value="" id="provider-postcode" required />
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="provider-postal-as-above">Postal address same as above?</label>
          <select name="postal_as_above" id="provider-postal-as-above" required>
            <option value="">Please select...</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
        <div class="form-group postal-address-row">
          <label for="provider-postal-address">Postal Address</label>
          <textarea name="postal_address" id="provider-postal-address" class="small" required></textarea>
        </div>
        <div class="form-group">
          <label for="provider-abn">ABN</label>
          <input type="text" name="abn" value="" id="provider-abn" />
        </div>
        <div class="form-group">
          <label for="provider-description">How would you best describe your provider organisation?</label>
          <textarea name="describe_org" id="provider-description" class="small" required></textarea>
        </div>
        
        <h4 class="modal-subheading font-md wt-sb">Main Contact Details</h4>
        
        <div class="columned-group">
          <div class="column">
            <div class="form-group">
              <label for="provider-contact-first-name">First Name</label>
              <input type="text" name="first_name" value="" id="provider-contact-first-name" required />
            </div>
          </div>
          <div class="column">
            <div class="form-group">
              <label for="provider-contact-last-name">Last Name</label>
              <input type="text" name="last_name" value="" id="provider-contact-last-name" required />
            </div>
          </div>
        </div>
        <div class="columned-group">
          <div class="column">
            <div class="form-group">
              <label for="provider-contact-phone">Phone</label>
              <input type="text" name="phone" value="" id="provider-contact-phone" required />
            </div>
          </div>
          <div class="column">
            <div class="form-group">
              <label for="provider-contact-mobile">Mobile</label>
              <input type="text" name="mobile" value="" id="provider-contact-mobile" />
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="provider-contact-email">Email</label>
          <input type="email" name="email" value="" id="provider-contact-email" required />
        </div>
        <div class="form-group">
          <label for="provider-contact-position">Position</label>
          <input type="text" name="position" value="" id="provider-contact-position" />
        </div>
        <div class="form-group">
          <label for="provider-contact-fax">Fax</label>
          <input type="text" name="fax" value="" id="provider-contact-fax" />
        </div>
        <h4 class="modal-subheading font-md wt-sb">Manager Contact Details</h4>
        <div class="form-group">
          <label for="provider-manager-as-above">Manager contact details same as above?</label>
          <select name="manager_as_above" id="provider-manager-as-above" required>
            <option value="">Please select...</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
        <div class="columned-group manager-detail-row">
          <div class="column">
            <div class="form-group">
              <label for="provider-contact-first-name-manager">First name</label>
              <input type="text" name="manager_first_name" value="" id="provider-contact-first-name-manager" required />
            </div>
          </div>
          <div class="column">
            <div class="form-group">
              <label for="provider-contact-last-name-manager">Last Name</label>
              <input type="text" name="manager_last_name" value="" id="provider-contact-last-name-manager" required />
            </div>
          </div>
        </div>
        <div class="columned-group manager-detail-row">
          <div class="column">
            <div class="form-group">
              <label for="provider-contact-phone-manager">Phone</label>
              <input type="text" name="manager_phone" value="" id="provider-contact-phone-manager" required />
            </div>
          </div>
          <div class="column">
            <div class="form-group">
              <label for="provider-contact-mobile-manager">Mobile</label>
              <input type="text" name="manager_mobile" value="" id="provider-contact-mobile-manager" />
            </div>
          </div>
        </div>
        <div class="form-group manager-detail-row">
          <label for="provider-contact-email-manager">Email</label>
          <input type="email" name="manager_email" value="" id="provider-contact-email-manager" required />
        </div>
        <h4 class="modal-subheading font-md wt-sb"><em>Life!</em> Program Management</h4>
        <div class="form-group">
          <label for="provider-appropriate-space">Is there an appropriate space at your organisation or do you have access to an appropriate venue within the community for you to deliver the <em>Life!</em> Program course (i.e. private space for 8-15 people, chairs, computer/laptop and projector/screen)?</label>
          <select name="appropriate_space" id="provider-appropriate-space" required>
            <option value="">Please select...</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
        <div class="form-group">
          <label for="provider-referral-pathways">What referral pathways or networking opportunities are available to you in order to receive eligible participants for your <em>Life!</em> Program courses?</label>
          <textarea name="referral_pathways" id="provider-referral-pathways" class="small" required></textarea>
        </div>
        <div class="form-group">
          <label for="provider-delivery-areas">Which area/s would your organisation be interested in delivering the <em>Life!</em> Program course?</label>
          <textarea name="delivery_areas" id="provider-delivery-areas" class="small" required></textarea>
        </div>
        <div class="form-group">
          <label for="provider-data-entry">Will each facilitator be responsible for entry of participant data assigned to them; or will there be staff (i.e. administration/reception) responsible for this?</label>
          <textarea name="data_entry" id="provider-data-entry" class="small" required></textarea>
        </div>
        <div class="form-group">
          <label for="provider-community-events">Is there an appropriate space at your organisation or do you have access to an appropriate venue within the community for you to deliver the <em>Life!</em> Program course (i.e. private space for 8-15 people, chairs, computer/laptop and projector/screen)?</label>
          <select name="community_events" id="provider-community-events" required>
            <option value="">Please select...</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
        <h4 class="modal-subheading font-md wt-sb">Provider Insurance Details</h4>
        <div class="form-group">
          <div class="inner">
            <label for="thc-pl-insurance">Do you have Professional Indemnity Insurance coverage for at least $1,000,000 for any one claim and will this continue to be maintained for at least two years after the End Date* stated in the PSA?</label>
            <select name="pl_insurance" id="thc-pl-insurance" required>
              <option value="">Please select...</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <div class="supporting">* End Date will be the 30th June each year.</div>
        </div>
        <div class="form-group">
          <label for="thc-pl-insurer">What is the name of the company you have Public Liability Insurance with?</label>
          <input type="text" name="pl_insurer" value="" id="thc-pl-insurer" required />
        </div>
        <div class="form-group">
          <div class="inner">
            <label for="thc-pi-insurance">Do you have Professional Indemnity Insurance coverage for at least $1,000,000 for any one claim and will this continue to be maintained for at least two years after the End Date* stated in the PSA?</label>
            <select name="pi_insurance" id="thc-pi-insurance" required>
              <option value="">Please select...</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>
          <div class="supporting">* End Date will be the 30th June each year.</div>
        </div>
        <div class="form-group">
          <label for="thc-pi-insurer">What is the name of the company you have Professional Indemnity Insurance with?</label>
          <input type="text" name="pi_insurer" value="" id="thc-pi-insurer" required />
        </div>
        <h4 class="modal-subheading font-md wt-sb">GST Registration</h4>
        <div class="form-group">
          <label for="provider-gst-registered">Is this organisation registered for GST?</label>
          <select name="gst_registration" id="provider-gst-registered" required>
            <option value="">Please select...</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>
        <div class="form-group">
          <label for="provider-facilitator-names">Facilitator/s name (<em>Life!</em> trained facilitator/s or health professional/s to attend <em>Life!</em> facilitator training)</label>
          <textarea name="facilitator_names" id="provider-facilitator-names" class="small" required></textarea>
        </div>
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
          <input type="hidden" name="form_id" value="providerSignup" />
        </div>
      </form>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.inner -->
  <div class="dismiss-modal">
    <button type="button" class="icon" data-dismiss-modal aria-label="Dismiss modal"><?php echo life_icon('times'); ?></button>
  </div>
</div>
<!-- /#health-check-modal -->
