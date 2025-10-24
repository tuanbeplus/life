<?php if (count($sections) > 1 || trim(get_the_content())): ?>
  <section class="bg-white tabbed-content">
    <div class="center-frame">
      <div class="formatted main-content">
        <?= apply_filters('the_content', get_the_content()) ?>
      </div>
      <?php if (count($sections) > 1): ?>
        <div class="tabs">
          <div class="tab-togglers">
            <ul>
              <?php foreach ($sections as $idx => $section): ?>
                <li><button type="button" class="button muted block<?= ($idx == 0) ? ' active' : '' ?>" data-toggle-tab="success-stories-<?= $idx ?>" data-tab-set="success-stories"><?= $section['name'] ?></button></li>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      <?php endif ?>
    </div>
  </section>
<?php endif ?>

<div class="tab-content">
  <?php foreach ($sections as $idx => $section): ?>
    <div class="tab-inner<?= ($idx == 0) ? ' active' : '' ?>">
      <?php foreach ($section['stories'] as $sidx => $story): ?>
        <?php
          $fg = ($sidx % 2) ? 'off-white' : 'white';
          $curve = ($sidx > 0) ? $curves[$sidx % count($curves)] : null;
        ?>
        <section class="success-story bg-<?= $fg ?> <?= ($curve !== null) ? 'curve-top' : '' ?>">
          <?php if ($curve !== null): ?>
            <svg-edge-curve-<?= $curve ?>></svg-edge-curve-<?= $curve ?>>
          <?php endif ?>
          <div class="center-frame">
            <story-container
              :has-story="<?= $story['story'] ? 'true' : 'false' ?>"
              :image="<?= vueProp($story['image'] ?? null) ?>"
              fg="<?= $fg ?>"
            >
              <template #head>
                <h3 class="font-md wt-bold lh-std">Say hello to <?= $story['attribution'] ?> a <em>Life!</em> <?= $story['attribution_type'] ?></h3>
                <blockquote class="quoted">
                  <?= life_icon('quote-left') ?><p><?= apply_filters('the_brand', esc_html($story['quote'])) ?></p><?= life_icon('quote-right') ?>
                </blockquote>
              </template>
              <?= apply_filters('the_content', $story['story']) ?>
            </story-container>
          </div>
        </section>
      <?php endforeach ?>
    </div>
  <?php endforeach ?>
</div>
