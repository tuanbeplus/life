<section class="section-learn-about-header bg-off-white curve-top">
  <svg-edge-curve-1></svg-edge-curve-1>
  <h2 class="text-center font-lgr wt-bold lh-tight"><?php echo apply_filters('the_brand', $heading); ?></h2>
</section>
<section class="section-learn-about bg-off-white overflow-hidden">
  <div class="center-frame">
    <?php if (is_array($tabs)): ?>
      <?php
        $tabNav = contentTabsNavProp($tabs);
        // dd($tabNav);
        $lines = [1, 2, 3, 4, 5, 6, 7];
      ?>
      <sml-tabs-over-giant
        class="-tablet-head-nav-grid"
        :tabs="<?= vueProp($tabNav) ?>"
        :mobile-accordion="true"
      >
        <?php foreach ($tabs as $tabI => $tab): $slug = $tabNav[$tabI]['slug'] ?>
          <?php if ($tab['content_type'] === 'flows'): ?>
            <template #tab-<?= $tabI ?>-intro>
              <?= incTemplate('elements/flows-intro', [
                'flows' => $tab,
              ]) ?>
            </template>
            <?php foreach ($tab['flows'] as $flowI => $flow): ?>
              <template #tab-<?= $tabI ?>-flow-<?= $flowI ?>-tab>
                <?php if ($flow['title'] ?? false): ?>
                  <h3 class="font-md wt-sb lh-std"><?= apply_filters('the_brand', esc_html($flow['title'])) ?></h3>
                <?php endif ?>
                <?php if ($flow['description'] ?? false): ?>
                  <div class="content formatted">
                    <?= apply_filters('the_content', $flow['description']) ?>
                  </div>
                <?php endif ?>
              </template>
              <?php foreach (($flow['steps'] ?? []) as $stepI => $step): ?>
                <?php
                  $line_id = $lines[$stepI % count($lines)];
                  $line_code = str_pad($line_id, 2, '0', STR_PAD_LEFT);
                ?>
                <template #tab-<?= $tabI ?>-flow-<?= $flowI ?>-step-<?= $stepI ?>>
                  <div class="inner">
                    <h4 class="wt-sb font-md lh-std">
                      <?php if ( $step['step_tag'] ): ?>
                        <span class="fg-<?= $step['tag_colour'] ?>"><?= $step['step_tag'] ?></span>
                      <?php endif ?>
                      <?= apply_filters('the_brand', esc_html($step['heading'])) ?>
                    </h4>
                    <?php if ($step['icon']): ?>
                      <div class="icon-container">
                        <?= life_icon($step['icon']) ?>
                      </div>
                    <?php endif ?>
                    <?php if ($step['subheading']): ?>
                      <h4 class="fg-primary font-mdish wt-sb lh-std"><?= apply_filters('the_brand', esc_html($step['subheading'])) ?></h4>
                    <?php endif ?>
                    <?php if ($step['content']): ?>
                      <div class="content lh-mder">
                        <?= apply_filters('the_content', $step['content']) ?>
                      </div>
                    <?php endif ?>
                  </div>
                  <div class="line in v<?= $line_id ?>"><?= life_svg('lines/line-'.$line_code) ?></div>
                </template>
              <?php endforeach ?>
              <template #tab-<?= $tabI ?>-flow-<?= $flowI ?>-outro>
                <?php if ($flow['outro_content'] || $flow['outro_call_to_action']): ?>
                  <div class="outro">
                    <?php if ($flow['outro_content']): ?>
                      <div class="content formatted">
                        <?= apply_filters('the_content', $step['outro_content']) ?>
                      </div>
                    <?php endif ?>
                    <?php if ($flow['outro_call_to_action']): ?>
                      <div class="cta">
                        <a href="<?= $flow['outro_call_to_action'] ?>" class="button teal"><?= $flow['outro_call_to_action_label'] ? apply_filters('the_brand', esc_html($flow['outro_call_to_action_label'])) : 'Explore More' ?></a>
                      </div>
                    <?php endif ?>
                  </div>
                <?php endif ?>
              </template>
            <?php endforeach ?>
          <?php else: ?>
            <template #tab-<?= $tabI ?>>
              <div class="-content">
                <div
                  class="tab-inner padded"
                  data-tab-number="<?= $slug ?>"
                  data-tab-set="learn-about"
                >
                  <div class="inner">
                    <?php switch ($tab['content_type'] ?? null) {
                      case 'blocks':
                        echoTemplate('elements/block-list', ['blocks' => $tab['block_content']]);
                        break;
                      case 'stepped':
                        echoTemplate('elements/stepped-listing', ['group' => $slug, 'stepped' => $tab]);
                        break;
                      case 'link':
                        echo '<div class="content formatted">' . apply_filters('the_content', $tab['content']) . '</div>';
                        break;
                    } ?>
                  </div>
                </div>
              </div>
            </template>
          <?php endif ?>
        <?php endforeach ?>
      </sml-tabs-over-giant>
    <?php endif ?>
  </div>
</section>
