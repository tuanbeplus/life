<section class="section-resource-items download-resources bg-white">
  <div class="center-frame">
    <form id="order-resources" action="/" method="post" class="resource-listing" data-ajax-submit>
      <?php if ($resources): ?>
        <ul class="listing hard-resources -dl-button-pad-top-30">
          <?php foreach ($resources as $resource): ?>
            <li>
              <div class="inner">
                <?php if ($resource['feature_image']['url'] ?? false): ?>
                  <div class="image">
                    <img src="<?= $resource['feature_image']['url'] ?>" class="contain" />
                  </div>
                <?php endif ?>
                <div class="details">
                  <div class="content">
                    <h6 class="font-middling wt-sb lh-tight"><?= apply_filters('the_brand', $resource['title']) ?></h6>
                    <?php if ($resource['description']): ?>
                      <div class="formatted">
                        <?= apply_filters('the_content', $resource['description']) ?>
                      </div>
                    <?php endif ?>
                  </div>
                  <div class="download-file">
                    <a target="_blank" rel="noopener noreferrer" href="<?= $resource['button']['resource']['url'] ?>" class="button white"><?= life_icon('download') ?>
                      <?= $resource['button']['label'] ?? 'Download Free PDF' ?>
                    </a>
                  </div>
                </div>
              </div>
            </li>
          <?php endforeach ?>
        </ul>
      <?php else: ?>
        <div class="no-results">
          <p>Unfortunately there are no items to show here at this time.</p>
        </div>
      <?php endif ?>
    </form>
  </div>
</section>