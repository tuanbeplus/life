<div
  id="tracking-risk-level-en"
>
  <?php foreach ([
    // 'low' => 100,
    'medium-low' => 50,
    'medium-high' => 30,
    'high-low' => 14,
    'high-medium' => 7,
    'high-high' => 3,
  ] as $riskLevel => $numberOfPeople): ?>
    <p class="risk-<?= $riskLevel ?> en">Approximately <span class="wt-sb">1 person in <?= $numberOfPeople ?></span> with your score will develop diabetes within 5 years.</p>
  <?php endforeach ?>
</div>
