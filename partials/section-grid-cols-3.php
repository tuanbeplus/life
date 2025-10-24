<section
  class="section-grid-cols-3 <?= $bgColor ?? 'bg-off-white' ?> curve-top"
>
  <svg-edge-curve-1></svg-edge-curve-1>
  <?= incTemplate('elements/benefits-grid') ?>
  <?php if ($footer ?? false): ?>
    <div class="-footer">
      <div class="-text">
        <h3><?= nl2br(italizeLifeText($footer['benefitsLowerText'])) ?></h3>
      </div>
      <?= incTemplate('elements/modal-trigger-buttons', [
        'dialogId' => 'grid-cols-3',
      ]) ?>
    </div>
  <?php endif ?>
</section>
