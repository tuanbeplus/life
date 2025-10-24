<?php
$contentImage = $contentImage ?? null;
$keyLinks = $keyLinks ?? null;
$centeredLinkTarget = $centeredLink['target'] ?? null;
$withAside = ($contentImage || $keyLinks || $centeredLinkTarget);
?>
<section
  class="section-feature-content bg-off-white <?= ($withAside) ? '-with-aside' : '' ?>"
>
  <div class="-text">
    <div class="content formatted">
      <?= apply_filters('the_content', $contentText) ?>
    </div>
  </div>
  <?php if ($withAside): ?>
    <div class="-image">
      <div class="-container">
        <?php if ($contentImage): ?>
          <img
            src="<?= $contentImage ?>"
            class="contain ia-bottom"
            alt="Multi-cultural community"
            role="presentation"
            loading="lazy"
          />
        <?php endif ?>
        <?php if ($keyLinks): ?>
          <div class="cta-links">
            <ul>
              <?php foreach ($keyLinks as $link): ?>
                <li>
                  <a
                    href="<?= $link['link'] ?>"
                    class="button circled-icon <?= $link['background'] ?>"
                  >
                    <span><?= $link['label'] ?></span>
                    <?= life_icon('chevron-right') ?>
                  </a>
                </li>
              <?php endforeach ?>
            </ul>
          </div>
        <?php endif ?>
        <?php if ($centeredLinkTarget): ?>
          <div class="cta-links">
            <ul>
              <li>
                <a href="<?= $centeredLinkTarget ?>" class="button circled-icon teal">
                <span class="is-flex">
                <span><?= $centeredLink['label'] ?></span><?= life_icon('chevron-right') ?>
                </span>
                </a>
              </li>
            </ul>
          </div>
        <?php endif ?>
      </div>
    </div>
  <?php endif ?>
</section>
