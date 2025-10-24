<?php
if (!$tabs) {
  $tabs = [];
}
?>

<section class="bg-white">
  <div class="center-frame">
    <?php if (count($tabs) > 1): ?>
      <div class="tabs">
        <div class="tab-togglers">
          <ul>
            <?php foreach ($tabs as $idx => $tab): ?>
              <li>
                <button
                  type="button"
                  class="button muted block<?= ($idx == 0) ? ' active' : '' ?>"
                  data-toggle-tab="health-professionals-<?= $idx ?>"
                  data-tab-set="health-professionals"
                >
                  <?= apply_filters('the_brand', $tab['tab_heading']) ?>
                </button>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
    <?php endif ?>
  </div>
</section>

<div class="tab-content">
  <?php foreach ($tabs as $i => $tab): ?>
    <?= incTemplate('elements/section-subtabs-tab', [
      'idx' => $i,
      'tab' => $tab,
    ]) ?>
  <?php endforeach ?>
</div>
