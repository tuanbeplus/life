<?php if (WP_DEBUG): ?>
  <h1>get-involved-tabs.php deprecated</h1>
<?php else: ?>
  <section class="get-involved-tabs bg-white">
    <div class="center-frame">
      <?php if (is_array($tabs)): ?>
        <?php $tabNav = contentTabsNavProp($tabs) ?>
        <content-tabs
          class="-tablet-head-nav-grid"
          :tabs="<?= vueProp($tabNav) ?>"
          :mobile-accordion="true"
        >
          <?php foreach ($tabs as $i => $tab): $slug = $tabNav[$i]['slug'] ?>
            <template #tab-<?= $i ?>>
              <div class="-content">
                <div
                  class="tab-inner padded"
                  data-tab-number="<?= $slug ?>"
                  data-tab-set="learn-about"
                >
                  <div class="inner content-feature">
                    <div class="content formatted">
                      <?php echo apply_filters('the_content', $tab['content']); ?>
                    </div>
                    <?php if ( $tab['tab_feature_image'] ): ?>
                      <div class="image pull-left">
                        <div class="inner">
                          <img src="<?php echo $tab['tab_feature_image']['url']; ?>" class="contain ia-bottom" alt="" role="presentation" />
                        </div>
                      </div>
                    <?php endif ?>
                  </div>
                </div>
              </div>
            </template>
          <?php endforeach ?>
        </content-tabs>
      <?php endif ?>
    </div>
  </section>
<?php endif ?>