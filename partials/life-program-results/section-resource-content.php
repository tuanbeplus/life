<section class="download-resources bg-white">
  <div class="center-frame">
    <form id="order-resources" action="/" method="post" class="resource-listing" data-ajax-submit>
      <?php if ($content): ?>
        <div class="content formatted">
          <?= apply_filters('the_content', $content) ?>
        </div>
      <?php else: ?>
        <div class="no-results">
          <p>Unfortunately there is no content to show here at this time.</p>
        </div>
      <?php endif ?>
    </form>
  </div>
</section>