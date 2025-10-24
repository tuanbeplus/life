<?php
$videos = get_field('lpo_videos')['videos'] ?? [];
$svcButtonUrl = get_field('lpo_videos')['button']['target'] ?? null;
$svcButtonLabel = get_field('lpo_videos')['button']['label'] ?? null;
?>
<section class="lpo-video-content hidden">
  <div class="inner container lpo-video-container content-feature">
    <?php foreach ($videos as $video): ?>
      <div class="lpo-vc__player x-data-video">
        <video src="<?= $video['url'] ?>">
        </video>
      </div>
    <?php endforeach ?>
  </div>
  <?php if (empty($svcButtonLabel) || $svcButtonUrl): ?>
    <div class="center-frame lpo-video-container-button">
      <a href="<?= $svcButtonUrl ?>" class="button primary sm nc"><?= $svcButtonLabel ?></a>
    </div>
  <?php endif ?>
</section>