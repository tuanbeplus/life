<?php
foreach ($tabSections as $i => $tab) {
  $tabSections[$i]['slug'] = slugify($tab['tab_title']);
}
?>
<section class="section-tabbed-content bg-off-white padded overflow-hidden">
  <div class="center-frame">
    <?php
      $tabNav = array_map(fn($tab) => [
        'title' => apply_filters('the_brand', esc_html($tab['tab_title'])),
        'slug' => $tab['slug'],
        'type' => null,
        'href' => null,
      ], $tabSections);
    ?>
    <content-tabs
      class="-tablet-head-nav-grid"
      :tabs="<?= vueProp($tabNav) ?>"
      <?php if (isset($heading)): ?>
        heading="<?= htmlentities($heading) ?>"
      <?php endif ?>
    >
      <?php foreach ($tabSections as $idx => $tab): ?>
        <template #tab-<?= $idx ?>>
          <div class="-content">
            <div class="tab-inner<?= ($idx == 0) ? ' active' : '' ?>" data-tab-number="<?= $tab['slug'] ?>" data-tab-set="prevention">
              <?php if ($tab['tab_feature_image']): ?>
                <div class="tab-feature-image">
                  <h3 class="fg-white font-lgr wt-bold"><?= apply_filters('the_brand', esc_html($tab['tab_title'])) ?></h3>
                  <div class="background tinted tint-black darker">
                    <img src="<?= $tab['tab_feature_image']['sizes']['tab-feature'] ?>" class="cover" />
                  </div>
                </div>
              <?php endif ?>
              <div class="content formatted">
                <?= apply_filters('the_content', $tab['tab_content']) ?>
              </div>
              <?php if ($tab['tab_contact_heading']): ?>
                <div class="contact-cta">
                  <h5 class="font-md wt-bold fg-near-black lh-std"><?= apply_filters('the_brand', esc_html($tab['tab_contact_heading'])) ?></h5>
                  <ul class="contact-options">
                    <li>
                      <a href="/contact-us/" class="button primary">Contact Us</a>
                    </li>
                    <li>
                      <h5 class="font-md wt-bold fg-near-black">Call our team on <a href="tel:137475">13 74 75</a></h5>
                    </li>
                  </ul>
                </div>
              <?php endif ?>
            </div>
          </div>
        </template>
      <?php endforeach ?>
    </content-tabs>
    <?php if (false): ?>
      <div class="tabs">
        <div class="tab-togglers">
          <h2 class="wt-bold font-lgr align-center lh-tight">Discover steps to prevention</h2>
          <ul>
            <?php foreach ($tabSections as $i => $tab): ?>
              <li>
                <button
                  type="button"
                  class="button white block<?= ($i == 0) ? ' active' : '' ?>"
                  data-toggle-tab="<?= $tab['slug'] ?>"
                  data-tab-set="prevention"
                >
                  <?= apply_filters('the_brand', esc_html($tab['tab_title'])) ?>
                </button>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
        <div class="tab-content" data-tab-group="prevention">
          <?php foreach ($tabSections as $idx => $tab ): ?>
            <div class="tab-inner<?= ($idx == 0) ? ' active' : '' ?>" data-tab-number="<?= $tab['slug'] ?>" data-tab-set="prevention">
              <?php if ($tab['tab_feature_image']): ?>
                <div class="tab-feature-image">
                  <h3 class="fg-white font-lgr wt-bold"><?= apply_filters('the_brand', esc_html($tab['tab_title'])) ?></h3>
                  <div class="background tinted tint-black darker">
                    <img src="<?= $tab['tab_feature_image']['sizes']['tab-feature'] ?>" class="cover" />
                  </div>
                </div>
              <?php endif ?>
              <div class="content formatted">
                <?= apply_filters('the_content', $tab['tab_content']) ?>
              </div>
              <?php if ($tab['tab_contact_heading']): ?>
                <div class="contact-cta">
                  <h5 class="font-md wt-bold fg-near-black lh-std"><?= apply_filters('the_brand', esc_html($tab['tab_contact_heading'])) ?></h5>
                  <ul class="contact-options">
                    <li>
                      <a href="/contact-us/" class="button primary">Contact Us</a>
                    </li>
                    <li>
                      <h5 class="font-md wt-bold fg-near-black">Call our team on <a href="tel:137475">13 74 75</a></h5>
                    </li>
                  </ul>
                </div>
              <?php endif ?>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    <?php endif ?>
  </div>
</section>