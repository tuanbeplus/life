<?php
  $relatedArticles = get_field('related_articles');
  if ($relatedArticles):
?>
  <section
    class="bra content bg-white padded"
  >
    <div class="center-frame">
      <div class="formatted">
        <h4>Related Articles</h4>
        <ul class="bra-list listing">
          <?php foreach ($relatedArticles as $article): ?>
            <li>
              <?php
                $categories = [
                  'article' => 'Article',
                  'fact-sheet' => 'Fact Sheet',
                  'recipe' => 'Recipe',
                ];
                $categorySlug = get_the_category($article->ID)[0]->slug ?? '';
                $category = $categories[$categorySlug] ?? '';
              ?>
              <?php get_template_part('partials/elements/article', 'card', [
                'image' => get_the_post_thumbnail_url($article->ID),
                'category' => $category,
                'date' => date_format(date_create($article->post_date), 'F d, Y'),
                'title' => $article->post_title,
                'target' => get_permalink($article->ID)
              ]) ?>
            </li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
  </section>
<?php endif ?>