<?php
$videos = get_field('lpo_videos')['videos'] ?? [];
?>
<section class="lpo-video-content lpo__language-page">
  <div class="curve v1">
    <div class="svg-image">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1700 66.9">
        <path d="M-1 39.4s161.7-31.7 268-28 338 48 434 48 355-24.9 498.7-41.2C1343.3 1.9 1619 3.7 1701 13.4v57H-1v-31z"></path>
      </svg>
    </div>
  </div>
  <div class="center-frame lpo-video-container content-feature">
    <?php foreach ($videos as $video): ?>
      <div class="lpo-vc__player x-data-video">
        <video src="<?= $video['url'] ?>"></video>
      </div>
    <?php endforeach ?>
  </div>
</section>