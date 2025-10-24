<?php
$document = get_field('resource_document');
$type = get_field('resource_type');
$ingredients = get_field('recipe_ingredients');
$method = get_field('recipe_steps');

if ($document && $document['filesize']) {
  $units = ['b', 'kb', 'mb', 'gb'];
  $formatted_bytes = $document['filesize'];
  $idx = 0;
  while ($formatted_bytes > 1024) {
    $formatted_bytes /= 1024;
    $idx++;
  }
  $formatted_bytes = round($formatted_bytes, 2).' '.$units[$idx];
}
?>
<section class="content bg-white center-frame padded section-resource">
  <div>
    <div class="formatted main-content resource-content">
      <?= apply_filters('the_content', get_the_content()) ?>
      <?php if ($type == 'recipe'): ?>
        <div class="recipe-details formatted">
          <div class="recipe-ingredients">
            <h4>Ingredients</h4>
            <ul>
              <?php foreach ($ingredients as $ingredient): ?>
                <li><?= $ingredient['ingredient'] ?></li>
              <?php endforeach ?>
            </ul>
          </div>
          <div class="recipe-method">
            <h4>Method</h4>
            <ol>
              <?php foreach ($method as $step): ?>
                <li><?= $step['step'] ?></li>
              <?php endforeach ?>
            </ol>
            <?php if (get_field('resource_credits')): ?>
              <div class="supporting font-tiny lh-loose">
                <?= apply_filters('the_content', get_field('resource_credits')) ?>
              </div>
            <?php endif ?>
          </div>
        </div>
      <?php else: ?>
        <?php if (get_field('resource_credits')): ?>
          <div class="supporting font-tiny lh-loose">
            <?= apply_filters('the_content', get_field('resource_credits')) ?>
          </div>
        <?php endif ?>
      <?php endif ?>
    </div>
    <?php if ($document): ?>
      <div class="download-document">
        <a href="<?= $document['url'] ?>" class="wt-md"><?= life_icon('download') ?> Download <?= $document['filename'] ?> (<?= $formatted_bytes ?>)</a>
      </div>
    <?php endif ?>
  </div>
</section>
