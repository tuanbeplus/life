<div
  class="section-subtabs-tab -elements tab-inner<?= ($idx == 0) ? ' active' : '' ?> health-professionals-content"
  data-tab-number="health-professionals-<?= $idx ?>"
  data-tab-set="health-professionals"
>
  <?php if ($tab['tab_content']): ?>
    <section class="content bg-white">
      <div class="center-frame">
        <?php if ($tab['tab_feature_image']): ?>
          <div class="tab-feature-image">
            <h3
              class="fg-white font-lgr wt-bold"
            >
              <?= apply_filters('the_brand', esc_html($tab['tab_heading'])) ?>
            </h3>
            <div class="background tinted tint-black darker">
              <img src="<?= $tab['tab_feature_image']['sizes']['tab-feature'] ?>" class="cover" />
            </div>
          </div>
        <?php else: ?>
          <h3
            class="font-lg wt-sb"
            style="margin-bottom: 20px;"
          >
            <?= apply_filters('the_brand', $tab['tab_heading']) ?>
          </h3>
        <?php endif ?>
        <?php if ($tab['tab_content']): ?>
          <div class="content formatted">
            <?= apply_filters('the_content', $tab['tab_content']) ?>
          </div>
        <?php endif ?>
        <?php if ($tab['tab_related_resource']): ?>
          <div class="related-resource-cta">
            <a
              href="<?= $tab['tab_related_resource']['url'] ?>"
              class="button grey"
            >
              <?= life_icon('document') ?>
              <?= ($tab['tab_related_resource_label']) ? $tab['tab_related_resource_label'] : 'Download File' ?>
            </a>
          </div>
        <?php endif ?>
      </div>
    </section>
  <?php endif ?>
  <?php if ($tab['tab_secondary_content']): ?>
    <section class="secondary-content bg-off-white curve-top">
      <svg-edge-curve-1></svg-edge-curve-1>
      <div class="center-frame">
        <div class="content formatted">
          <?= apply_filters('the_content', $tab['tab_secondary_content']) ?>
        </div>
        <?php if ($tab['tab_secondary_contact_email'] || $tab['tab_secondary_contact_phone']): ?>
          <ul class="contact-options">
            <?php if ($tab['tab_secondary_contact_email']): ?>
              <li>
                <a
                  href="mailto:<?= $tab['tab_secondary_contact_email'] ?>"
                  class="button primary"
                >
                  <?= $tab['tab_secondary_contact_email'] ?>
                </a>
              </li>
            <?php endif ?>
            <?php if ($tab['tab_secondary_contact_phone']): ?>
              <li>
                <h5 class="font-mdish wt-sb fg-near-black"><?= life_icon('chat') ?> <a href="tel:<?= preg_replace('/[^0-9\+]/', '', $tab['tab_secondary_contact_phone']) ?>" class="fg-near-black"><?= apply_filters('the_brand', esc_html($tab['tab_secondary_contact_phone'])) ?></a></h5>
              </li>
            <?php endif ?>
          </ul>
        <?php endif ?>
      </div>
    </section>
  <?php endif ?>
  <?php if ($tab['tab_tertiary_content']): ?>
    <section class="tertiary-content bg-white">
      <div class="center-frame">
        <div class="content formatted">
          <?= apply_filters('the_content', $tab['tab_tertiary_content']) ?>
        </div>
        <?php if ($tab['tertiary_content_email']): ?>
          <ul class="contact-options">
            <?php if ($tab['tab_secondary_contact_email']): ?>
              <li>
                <a href="mailto:<?= $tab['tertiary_content_email'] ?>" class="button primary">
                  <?= life_icon('email') ?>
                  <?php if ($tab['tertiary_content_email_label']): ?>
                    <?= $tab['tertiary_content_email_label'] ?>
                  <?php else: ?>
                    <?= $tab['tab_secondary_contact_email'] ?>
                  <?php endif ?>
                </a>
              </li>
            <?php endif ?>
          </ul>
        <?php endif ?>
      </div>
    </section>
  <?php endif ?>
  <?php if ($tab['success_story_quote']): ?>
    <section
      class="success-story bg-off-white curve-top"
    >
      <svg-edge-curve-2></svg-edge-curve-2>
      <div class="center-frame">
        <div class="story-container">
          <div class="story">
            <?php if ($tab['success_story_heading']): ?>
              <h3 class="font-lgr wt-bold lh-std"><?= apply_filters('the_brand', esc_html($tab['success_story_heading'])) ?></h3>
            <?php endif ?>
            <blockquote class="quoted">
              <?= life_icon('quote-left') ?><p><?= apply_filters('the_brand', esc_html($tab['success_story_quote'])) ?></p><?= life_icon('quote-right') ?>
            </blockquote>
            <div class="attribution">
              <?php if ($tab['success_story_attribution_label'] && $tab['success_story_attribution_group']): ?>
                <p><?= $tab['success_story_attribution'] ?> a <em>Life!</em> <?= $tab['success_story_attribution_label'] ?> at <?= $tab['success_story_attribution_group'] ?></p>
              <?php elseif ($tab['success_story_attribution_label']): ?>
                <p><?= $tab['success_story_attribution'] ?> a <em>Life!</em> <?= $tab['success_story_attribution_label'] ?></p>
              <?php elseif ($tab['success_story_attribution_group']): ?>
                <p><?= $tab['success_story_attribution'] ?>, <?= $tab['success_story_attribution_group'] ?></p>
              <?php else: ?>
                <p><?= $tab['success_story_attribution'] ?></p>
              <?php endif ?>
            </div>
          </div>
          <?php if ($tab['success_story_image']): ?>
            <div class="image fg-off-white">
              <div class="inner masked">
                <img src="<?= $tab['success_story_image']['sizes']['testimonial'] ?>" class="cover" />
                <div class="mask"><?= life_svg('backgrounds/testimonial-mask') ?></div>
              </div>
            </div>
          <?php endif ?>
        </div>
      </div>
    </section>
  <?php endif ?>
</div>
