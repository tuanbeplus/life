<?php
$lang = get_the_ID() == GESTATIONAL_VIETNAMESE ? 'vi' : 'en';
?>
<div id="gestational-form-modal" data-lang="<?= $lang ?>">
  <div class="-window">
    <div class="dismiss-modal">
      <button
        type="button"
        class="icon"
        data-dismiss-modal
        aria-label="Dismiss modal"
      ><?php echo life_icon('times') ?></button>
    </div>
    <?php if ($lang === 'vi'): ?>
      <h2>Đăng ký tham gia chương trình</h2>
    <?php else: ?>
      <h2>Register for the <i>Life!</i> program</h2>
      <h3
        class="font-middling wt-sb lh-tight"
      >Submit your details and we will get back to you shortly.</h3>
    <?php endif ?>
    <form
      id="health-check-contact"
      action="/"
      method="post"
      class="screening-email"
    >
      <div class="columned-group">
        <div class="column">
          <div class="form-group">
            <label for="send-contact-first-name"><?= ($lang === 'vi') ? 'Tên' : 'First name' ?></label>
            <input
              id="send-contact-first-name"
              type="text"
              name="first_name"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                value="GDM Test <?= date('m_d_h_i_s') ?>"
              <?php endif ?>
              required
              data-parsley-error-message="<?= ($lang === 'vi') ? 'Giá trị này là bắt buộc.' : 'This value is required.' ?>"
            />
          </div>
        </div>
        <div class="column">
          <div class="form-group">
            <label for="send-contact-last-name"><?= ($lang === 'vi') ? 'Họ' : 'Last names' ?></label>
            <input
              id="send-contact-last-name"
              type="text"
              name="last_name"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                value="BrightLabs Lee"
              <?php endif ?>
              required
              data-parsley-error-message="<?= ($lang === 'vi') ? 'Giá trị này là bắt buộc.' : 'This value is required.' ?>"
            />
          </div>
        </div>
      </div>
      <div class="columned-group">
        <div class="column">
          <div class="form-group">
            <label for="send-contact-email"><?= ($lang === 'vi') ? 'Địa chỉ email' : 'Email' ?></label>
            <input
              id="send-contact-email"
              type="email"
              name="email"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                value="lee+<?= date('m_d_h_i_s') ?>@brightlabs.com.au"
              <?php endif ?>
              required
              data-parsley-error-message="<?= ($lang === 'vi') ? 'Giá trị này phải là một email hợp lệ.' : 'This should be a valid email.' ?>"
            />
          </div>
        </div>
        <div class="column">
          <div class="form-group">
            <label for="send-contact-phone">
              <?= ($lang === 'vi') ? 'Số điện thoại' : 'Mobile Phone' ?>
            </label>
            <input
              id="send-contact-phone"
              type="tel"
              name="phone"
              title="Enter 10 digit phone number without spaces"
              data-parsley-type="number"
              data-parsley-maxlength="10"
              data-parsley-minlength="10"
              data-parsley-type-message="<?= ($lang === 'vi') ? 'Giá trị không hợp lệ. Vui lòng chỉ sử dụng số.' : 'Invalid value. Please use numbers only' ?>"
              data-parsley-maxlength-message="<?= ($lang === 'vi') ? 'Giá trị không quá dài. Nó phải có 10 ký tự.' : 'This value is too long. It should have 10 characters.' ?>"
              data-parsley-minlength-message="<?= ($lang === 'vi') ? 'Giá trị này quá ngắn. Nó phải có 10 ký tự.' : 'This value is too short. It should have 10 characters.' ?>"
              <?php if (AUTOFILL_CONTACT_FORM): ?>
                value="0415419771"
              <?php endif ?>
              required
              data-parsley-error-message="<?= ($lang === 'vi') ? 'Giá trị không hợp lệ. Vui lòng chỉ sử dụng số.' : 'Invalid value. Please use number only.' ?>"
            />
          </div>
        </div>
      </div>
      <div class="form-group" style="margin-bottom: 14px">
        <label><?= ($lang === 'vi') ? 'Hiện bạn có đang mang thai và bị tiểu đường thai kỳ không?' : 'Are you currently pregnant with gestational diabetes?' ?></label>
        <div class="block-radio-group thirds">
          <div class="block-radio">
              <label class="option label">
                  <input type="radio" name="currently_gdm" value="Yes">
                  <span class="option-label">
                      <span><?= ($lang === 'vi') ? 'Có' : 'Yes' ?></span>
                  </span>
              </label>
          </div>
          <div class="block-radio">
              <label class="option label">
                  <input type="radio" name="currently_gdm" value="No">
                  <span class="option-label">
                      <span><?= ($lang === 'vi') ? 'Không' : 'No' ?></span>
                  </span>
              </label>
          </div>
        </div>
      </div>
      <div
        class="form-group hidden"
        data-conditional-field-form-modal="currently_gdm"
      >
        <label for="due_date"><?= ($lang === 'vi') ? 'Ngày dự sinh của bạn là ngày mấy?' : 'What is your due date?' ?></label>
        <input
          id="due_date"
          type="date"
          name="due_date"
        />
      </div>
      <div class="columned-group">
        <div class="column">
          <div class="form-group">
            <label for="send-contact-via"><?= ($lang === 'vi') ? 'Bạn đã nghe về chúng tôi từ ở đâu?' : 'How did you hear about us?' ?></label>
            <select id="send-contact-via" name="heard_about_via">
              <option value=""><?= ($lang === 'vi') ? 'Vui lòng chọn' : 'Please select' ?>...</option>
              <option value="NDSS email"><?= ($lang === 'vi') ? 'Qua email NDSS' : 'NDSS email' ?></option>
              <option value="Maternal Child Health"><?= ($lang === 'vi') ? 'Chăm sóc sức khỏe mẫu nhi' : 'Maternal Child Health' ?></option>
              <option value="GDM Flyer"><?= ($lang === 'vi') ? 'Tờ rơi về bệnh tiểu đường sau thai kỳ' : 'GDM Flyer' ?></option>
              <option value="GDM Brochure"><?= ($lang === 'vi') ? 'Tờ thông tin về bệnh tiểu đường sau thai kỳ' : 'GDM Brochure' ?></option>
              <option value="Hospital"><?= ($lang === 'vi') ? 'bệnh viện' : 'Hospital' ?></option>
              <option value="GP"><?= ($lang === 'vi') ? 'bác sĩ gia đình' : 'GP' ?></option>
              <option value="Google Search"><?= ($lang === 'vi') ? 'tìm kiếm từ Google' : 'Google search' ?></option>
              <option value="Word of Mouth"><?= ($lang === 'vi') ? 'Truyền miệng' : 'Word of mouth' ?></option>
              <option value="Health Professional"><?= ($lang === 'vi') ? 'Chuyên viên Y Tế' : 'Health Professional' ?></option>
              <option
                value="Other"
                <?php if (AUTOFILL_CONTACT_FORM): ?>
                  selected
                <?php endif ?>
              ><?= ($lang === 'vi') ? 'chỗ khác' : 'Other' ?></option>
            </select>
          </div>
        </div>
      </div>
      <?php if ($lang === 'vi'): ?>
        <div class="form-group" style="margin-bottom: 14px">
          <label>Bạn có cẫn thông dịch viên không?</label><!-- Do you need an interpreter -->
          <div class="block-radio-group thirds">
            <div class="block-radio">
                <label class="option label">
                    <input type="radio" name="Do_you_need_an_interpreter__c" value="Yes">
                    <span class="option-label">
                        <span>Có</span>
                    </span>
                </label>
            </div>
            <div class="block-radio">
                <label class="option label">
                    <input type="radio" name="Do_you_need_an_interpreter__c" value="No">
                    <span class="option-label">
                        <span>Không</span>
                    </span>
                </label>
            </div>
          </div>
        </div>
        <div class="form-group">
            <div class="type-checkbox">
                <label class="option label">
                    <input type="checkbox" name="Vietnamese_woman__c" value="yes">
                    <span class="option-label">Tôi là một phụ nữ Việt Nam</span><!-- I am a Vietnamese woman -->
                    <?php echo life_icon('check'); ?>
                </label>
            </div>
        </div>
        <div class="form-group" style="margin-bottom: 14px">
          <label>Bạn có cần chương trình được cung cấp bằng tiếng Việt không?</label><!-- Do you require the program to be delivered in Vietnamese -->
          <div class="block-radio-group thirds">
            <div class="block-radio">
                <label class="option label">
                    <input type="radio" name="Program_to_be_deliver_Vietnamese__c" value="Yes">
                    <span class="option-label">
                        <span>Có</span>
                    </span>
                </label>
            </div>
            <div class="block-radio">
                <label class="option label">
                    <input type="radio" name="Program_to_be_deliver_Vietnamese__c" value="No">
                    <span class="option-label">
                        <span>Không</span>
                    </span>
                </label>
            </div>
          </div>
        </div>
      <?php endif ?>
      <div class="form-group hidden" data-conditional-field="health_professional">
        <label for="health_professional">Name of the health professional (optional)</label>
        <input
          id="health_professional"
          type="text"
          name="health_professional"
          placeholder="Health professional"
        />
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
            <?php if ($lang === 'vi'): ?>
              <span class="option-label">Tôi đồng ý cho nhân viên của Diabetes Victoria từ chương trình <em>Life!</em> Program liên hệ với tôi về chương trình này và cho bất kỳ thông tin cá nhân nào được thu thập để sử dụng cho các hoạt động quản trị của chương trình <em>Life!</em></span>
            <?php else: ?>
              <span class="option-label">I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to contact me regarding the <em>Life!</em> program and for any personal information collected to be used for necessary <em>Life!</em> program administrative operations.</span>
            <?php endif ?>
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
          <span><?= ($lang === 'vi') ? 'Trở lại trang chủ.' : 'Return to Site.' ?></span>
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
          <span><?= ($lang === 'vi') ? 'Gửi thông tin' : 'Submit Details' ?></span>
        </button>
        <input type="hidden" name="action" value="life_ajax_submit_form"/>
        <input type="hidden" name="form_id" value="gestational"/>
        <input type="hidden" name="language" value="<?= ($lang === 'vi') ? 'vietnamese' : 'english' ?>"/>
      </div>
    </form>
  </div>
</div>