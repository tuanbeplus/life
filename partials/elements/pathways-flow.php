<?php if (WP_DEBUG): ?>
  <h1>section-learn-about.php deprecated</h1>
<?php else:
// dd($pathways['flows']);
$tabNav = array_map(fn($tab) => [
  'title' => apply_filters('the_brand', esc_html($tab['title'])),
  'slug' => slugify($tab['title']),
  'description' => $tab['description'] ? apply_filters('the_content', $tab['description']) : null,
], $pathways['flows']);
$lines = [1, 2, 3, 4, 5, 6, 7];

?>
  <content-giant-tabs
    :tabs="<?= vueProp($tabNav) ?>"
  >
    <?php if ($pathways['flow_intro']): ?>
      <template #intro>
        <div class="intro">
          <?php if ( $pathways['flow_intro_icon'] ): ?>
            <div class="icon-feature">
              <?= life_icon($pathways['flow_intro_icon']) ?>
            </div>
          <?php endif ?>
          <?php if ( $pathways['flow_intro'] ): ?>
            <div class="content formatted">
              <?= apply_filters('the_content', $pathways['flow_intro']) ?>
            </div>
          <?php endif ?>
        </div>
      </template>
    <?php endif ?>
    <?php foreach ($pathways['flows'] as $i => $flow): ?>
      <template #tab-<?= $i ?>>
        <div class="pathway">
          <?php if ($flow['steps']): ?>
            <pathway-steps
              :num-steps="<?= count($flow['steps']) ?>"
            >
              <?php foreach ($flow['steps'] as $j => $step): ?>
                <?php
                  $line_id = $lines[$j % count($lines)];
                  $line_code = str_pad($line_id, 2, '0', STR_PAD_LEFT);
                ?>
                <template #step-<?= $j ?>>
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
            </pathway-steps>
          <?php endif ?>
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
        </div>
      </template>
    <?php endforeach ?>
  </content-giant-tabs>
<?php endif ?>