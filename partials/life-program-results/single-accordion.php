<single-accordion
  heading="<?= ($heading = $section['heading']) ? $heading : null ?>"
>
  <?= incTemplate(
    'life-program-results/section-subtabs',
    [
      'tabs' => $section['tabs'] ?? [],
    ],
  ) ?>
</single-accordion>