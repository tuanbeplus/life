<?php
    $bCategory = $args['category'] ?? '';
    $bDate = $args['date'] ?? '';
    $bTitle = $args['title'] ?? '';
    $bTarget = $args['target'] ?? '';
    $bImage = empty($args['image'])? '/wp-content/themes/life/images/placeholders/resource.jpg': $args['image'];
?>
<a
    data-name="e.article-card"
    href="<?= $bTarget ?>"
    class="ac"
>
    <div class="ac__image">
        <picture>
            <img
                src="<?= $bImage ?>"
                alt=""
            >
        </picture>
    </div>
    <div class="ac__details">
        <h5><?= $bCategory ?></h5>
        <div class="ac__date"><?= $bDate ?></div>
        <h4><?= $bTitle ?></h4>
    </div>
    <div class="ac__cta">
        <span class="uc wt-sb font-sm"><?= life_icon('document'); ?> Read</span>
    </div>
</a>