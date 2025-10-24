<section class="block-video-content-alt">
  <div class="center-frame content-feature">
    <div class="formatted main-content">
      <h1 class="font-lgr wt-bold lh-tight"><?= $title ?></h1>
    </div>
  </div>
  <div class="center-frame">
    <div class="video-grid">
      <?php foreach ($videos as $i => $video): ?>
        <?php
          $video_url = $video['url'];
          // Convert youtu.be URL to embed format
          if (strpos($video_url, 'youtu.be/') !== false) {
              $video_id = substr($video_url, strrpos($video_url, '/') + 1);
              $embed_url = "https://www.youtube.com/embed/" . $video_id;
          }
          // Convert youtube.com URL to embed format
          elseif (strpos($video_url, 'youtube.com/watch?v=') !== false) {
              parse_str(parse_url($video_url, PHP_URL_QUERY), $params);
              $video_id = $params['v'];
              $embed_url = "https://www.youtube.com/embed/" . $video_id;
          }
          else {
              $embed_url = $video_url;
          }
        ?>
        <iframe
          title="The Life! program"
          src="<?= $embed_url ?>?rel=0&modestbranding=1"
          width="537"
          height="302"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
          style="max-width: 100%;"
        ></iframe>
      <?php endforeach ?>
    </div>
  </div>
</section>