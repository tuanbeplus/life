<?php
/**
 * Template Name: Get Involved
 */

setup_postdata($post);

get_header(null, ['bodyClass' => 'template-get-involved']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

if ($sectionLevel2Content = get_the_content()) {
  echoTemplate('section-level2', [
    'content' => $sectionLevel2Content,
    'sidebarBlocks' => get_field('sidebar_blocks'),
  ]);
}

if (($tabs = get_field('sections')) && is_array($tabs)): ?>
  <get-involved-tabs
    :tabs="<?= vueProp(contentTabsNavProp($tabs)) ?>"
  >
    <?php foreach ($tabs as $i => $tab): ?>
      <template #tab-<?= $i ?>>
        <div class="-content">
          <div
            class="tab-inner padded"
          >
            <div class="inner content-feature">
              <div class="content formatted">
                <?= apply_filters('the_content', $tab['content']) ?>
              </div>
              <?php if ($tab['tab_feature_image']): ?>
                <div class="image pull-left">
                  <div class="inner">
                    <img src="<?= $tab['tab_feature_image']['url'] ?>" class="contain ia-bottom" alt="" role="presentation" />
                  </div>
                </div>
              <?php endif ?>
            </div>
          </div>
        </div>
      </template>
      <?php $testimonial_bg = $tab['register_interest_link'] ? 'white' : 'off-white' ?>
      <template #lower-<?= $i ?>>
        <div class="tab-inner<?= ($idx == 0) ? ' active' : '' ?>">
          <?php if ($tab['register_interest_link']): ?>
            <section class="contact-cta-block bg-off-white curve-top">
              <svg-edge-curve-3></svg-edge-curve-3>
              <div class="center-frame">
                <div class="content">
                  <h3 class="heading font-lgr wt-bold lh-tight"><?= $tab['register_interest_heading'] ? apply_filters('the_brand', esc_html($tab['register_interest_heading'])) : 'Get in touch!' ?></h3>
                  <div class="cta">
                    <a href="<?= $tab['register_interest_link'] ?>" class="button grey"><?= life_icon('document') ?><span><?= ($tab['register_interest_label']) ? apply_filters('the_brand', esc_html($tab['register_interest_label'])) : 'Register your interest' ?></span></a>
                  </div>
                  <?php if ($tab['register_contact_link'] || $tab['register_interest_number']): ?>
                    <h5 class="subheading font-mdish wt-sb lh-std">For more information please contact the <em>Life!</em> team</h5>
                    <ul class="contact-options">
                      <?php if ($tab['register_contact_link']): ?>
                        <li>
                          <a href="<?= $tab['register_contact_link'] ?>" class="button primary"><?= life_icon('email') ?><span>Contact our team</span></a>
                        </li>
                      <?php endif ?>
                      <?php if ($tab['register_interest_number']): ?>
                        <li>
                          <h5 class="font-mdish wt-sb fg-near-black"><?= life_icon('chat') ?> <a href="tel:<?= preg_replace('/[^0-9\+]/', '', $tab['register_interest_number']) ?>" class="fg-near-black"><?= apply_filters('the_brand', esc_html($tab['register_interest_number'])) ?></a></h5>
                        </li>
                      <?php endif ?>
                    </ul>
                  <?php endif ?>
                </div>
              </div>
            </section>
          <?php endif ?>
          <?php if ($tab['testimonials']): ?>
            <?= incTemplate('testimonials/block-testimonials', [
              'testimonials' => $tab['testimonials'],
              'scheme' => $testimonial_bg,
            ]) ?>
          <?php endif ?>
        </div>
      </template>
    <?php endforeach ?>
  </get-involved-tabs>
<?php endif;

get_footer();
