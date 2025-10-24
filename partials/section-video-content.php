<?php if (count($bVideos = (get_field('videos') ?? null ?: [])) >= 2): ?>
  <div class="section-video-content">
    <div class="center-frame">
      <video-slideshow
        :slides="<?= htmlentities(json_encode($bVideos)) ?>"
      ></video-slideshow>
    </div>
  </div>
<?php endif ?>