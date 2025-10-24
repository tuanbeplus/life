<?php
$articles = $articlesQuery->posts;
$articlesForVue = array_map(fn($p) => [
  'id' => $p->ID,
  'categories' => postCategories($p->ID),
], $articles);
?>
<section class="blog-index">
  <div class="center-frame">
    <header>
      <?= apply_filters('the_content', $headerContent) ?>
    </header>
    <blog-index-tabbed
      :articles="<?= vueProp($articlesForVue) ?>"
      :possible-categories="<?= vueProp(blogCategories()) ?>"
      :per-page="16"
    >
      <?php foreach ($articles as $i => $article): ?>
        <template v-slot:article-<?= $article->ID ?>>
          <a
            class="-article"
            href="<?= get_the_permalink($article->ID) ?>"
          >
            <div class="-img">
              <img
                src="<?= thumbnail('resource-tile', 'resource.jpg', $article) ?>"
                alt="<?= $article->post_title ?>"
                class="contain"
              />
            </div>
            <div class="details">
              <h5 class="-cat"><?= blogCategoryLabels($articlesForVue[$i]['categories']) ?></h5>
              <?php $t = strtotime($article->post_date) ?>
              <time
                datetime="<?= date("Y-m-d", $t) ?>"
              ><?= date("F j, Y", $t) ?></time>
              <h3><?= apply_filters('the_brand', apply_filters('the_title', $article->post_title)) ?></h3>
              <div class="cta wt-sb font-sm">
                <svg-icon-document></svg-icon-document>
                <span>Read</span>
              </div>
            </div>
          </a>
        </template>
      <?php endforeach ?>
    </blog-index-tabbed>
  </div>
</section>

