
<?php if ($block_callouts = get_field('block_callouts')): ?>
  <section class="bg-white panel-strip curve-top">
    <svg-edge-curve-3></svg-edge-curve-3>
    <div class="center-frame">
      <?php if ($block_cta_heading = get_field('block_cta_heading')): ?>
        <h3 class="font-md wt-sb lh-std align-center">
          <?= apply_filters('the_brand', $block_cta_heading) ?>
        </h3>
      <?php endif ?>
      <ul class="listing panels">
        <?php foreach ($block_callouts as $callout): ?>
          <li>
            <?php if ($callout['link_to']): ?>
              <a
                href="<?= $callout['link_to'] ?>"
                class="inner bg-white"
              >
                <?= incTemplate('widget/panel-strip-callout', $callout) ?>
              </a>
            <?php else: ?>
              <div class="inner bg-white">
                <?= incTemplate('widget/panel-strip-callout', $callout) ?>
              </div>
            <?php endif ?>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
  </section>
<?php endif ?>
