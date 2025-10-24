
<?php if ($register_interest_link = get_field('register_interest_link')): ?>
  <section class="block-register-interest contact-cta-block bg-off-white curve-top">
    <svg-edge-curve-3></svg-edge-curve-3>
    <div class="center-frame">
      <div class="content">
        <h3 class="heading font-lgr wt-bold lh-tight">
          <?= ($register_interest_heading = get_field('register_interest_heading'))
            ? apply_filters('the_brand', esc_html($register_interest_heading))
            : 'Get in touch!'
          ?>
        </h3>
        <div class="cta">
          <a href="<?= $register_interest_link ?>" class="button grey">
            <?= life_icon('document') ?>
            <span><?= ($label = get_field('register_interest_label'))
              ? apply_filters('the_brand', esc_html($label))
              : 'Register your interest'
            ?></span>
          </a>
        </div>
        <?php if (get_field('register_contact_link') || get_field('register_interest_number')): ?>
          <h5 class="subheading font-mdish fg-primary wt-sb lh-std">For more information please contact the <em>Life!</em> team</h5>
          <ul class="contact-options">
            <?php if (get_field('register_contact_link')): ?>
              <li>
                <a href="<?= get_field('register_contact_link') ?>" class="button primary">
                  <?= life_icon('email') ?><span>Contact our team</span>
                </a>
              </li>
            <?php endif ?>
            <?php if ($register_interest_number = get_field('register_interest_number')): ?>
              <li>
                <h5 class="font-mdish wt-sb fg-near-black">
                  <?= life_icon('chat') ?>
                  <a
                    href="tel:<?= preg_replace('/[^0-9\+]/', '', $register_interest_number) ?>"
                    class="fg-near-black"
                  >
                    <?= apply_filters('the_brand', esc_html($register_interest_number)) ?>
                  </a>
                </h5>
              </li>
            <?php endif ?>
          </ul>
        <?php endif ?>
      </div>
    </div>
  </section>
<?php endif ?>
