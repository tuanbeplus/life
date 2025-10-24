<footer class="page-footer">
  <div class="upper">
    <div class="center-frame">
      <div class="_logos-and-contact">
        <div class="_logos">
          <a
            class="_logo -life"
            href="<?= home_url() ?>"
          >
            <img src="<?= get_template_directory_uri() . '/images/logos/footer/Life-logo.svg' ?>" alt="Life! logo" />
          </a>
          <a
            href="https://www.diabetesvic.org.au/"
            class="_logo -dv"
            aria-label="Diabetes Victoria"
            title="Diabetes Victoria"
            target="_blank"
            rel="noopener noreferrer"
          >
            <img src="<?= get_template_directory_uri() . '/images/logos/footer/DV.svg' ?>" alt="Life! logo" />
          </a>
          <a
            href="https://www.dhhs.vic.gov.au/"
            class="_logo -vic-gov"
            aria-label="Victoria State Government"
            title="Victoria State Government"
            target="_blank"
            rel="noopener noreferrer"
          >
            <img src="<?= get_template_directory_uri() . '/images/logos/footer/Vic-gov.svg' ?>" alt="Life! logo" />
          </a>
          <p class="_caption font-for-ants">The <em>Life!</em> program is supported by the Victorian Government</p>
        </div>
        <div class="_contact">
          <span class="wt-md font-std lh-std">Get in touch with our helpful team today on our infoline</span>
          <ul class="wt-sb font-lg">
            <li><a href="tel:137475" class="fg-primary risk-13-wcag">13 RISK</a></li>
            <li><a href="tel:137475" class="fg-near-black">13 74 75</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php if ($nav_items = life_nav_items('footer')): ?>
    <div class="links">
      <footer-nav-accordion :cols="<?= vueProp(array_map(fn($col) => ['url' => $col->url], $nav_items)) ?>">
        <?php foreach ($nav_items as $i => $item): ?>
          <template #title-<?= $i ?>>
            <?php if ($item->url !== '#'): ?>
              <a href="<?= $item->url ?>" class="fg-near-black wt-bold uc"><?= $item->title ?></a>
            <?php else: ?>
              <h4 class="wt-bold fg-near-black uc"><?= $item->title ?></h4>
            <?php endif ?>
          </template>
          <template #links-<?= $i ?>>
            <?php if ($item->childItems): ?>
              <ul class="-height">
                <?php foreach ($item->childItems as $child_item): ?>
                  <li><a href="<?= $child_item->url ?>" class="fg-near-black <?= implode(' ', $item->classes) ?><?= (!preg_match('#://'.str_replace('.', '\.', $_SERVER['HTTP_HOST']).'/#', $child_item->url) && preg_match('#://#', $child_item->url)) ? ' external' : '' ?>"><?= $child_item->title ?></a></li>
                <?php endforeach ?>
              </ul>
            <?php endif ?>
          </template>
        <?php endforeach ?>
      </footer-nav-accordion>
    </div>
  <?php endif ?>
  <div class="acknowledgement">
    <div class="center-frame">
      <div class="message">
        <p>Diabetes Victoria acknowledges the traditional custodians of our lands and pays respect to their Elders, past and present.</p>
        <p>We strive to reduce the impact of diabetes on Aboriginal and Torres Strait Islander people living in Victoria.</p>
      </div>
    </div>
  </div>
  <div class="lower bg-off-white">
    <div class="center-frame font-tiny">
      <div class="socials">
        <ul>
          <?php if ($life_facebook_link = get_option('life_facebook_link')): ?>
            <li><a href="<?= $life_facebook_link ?>" class="external" target="_blank" rel="noopener">
              <svg-icon-fb></svg-icon-fb>
              <span class="visually-hidden">Find us on Facebook</span>
            </a></li>
          <?php endif ?>
          <?php if ($life_linkedin_link = get_option('life_linkedin_link')): ?>
            <li><a href="<?= $life_linkedin_link ?>" class="external" target="_blank" rel="noopener">
              <svg-icon-insta></svg-icon-insta>
              <span class="visually-hidden">Connect on LinkedIn</span>
            </a></li>
          <?php endif ?>
          <?php if ($life_instagram_link = get_option('life_instagram_link')): ?>
            <li><a href="<?= $life_instagram_link ?>" class="external" target="_blank" rel="noopener">
              <svg-icon-insta></svg-icon-insta>
              <span class="visually-hidden">Find us on Instagram</span>
            </a></li>
          <?php endif ?>
        </ul>
      </div>
      <div class="legals">
        <ul>
        <?php if ($legal_items = life_nav_items('legals')): ?>
          <?php foreach ($legal_items as $menu_item): ?>
            <li><a href="<?= $menu_item->url ?>" class="fg-near-black"><?= $menu_item->title ?></a></li>
          <?php endforeach ?>
        <?php endif ?>
        </ul>
      </div>
      <div class="notices">
        <ul>
          <li class="copyright">&copy; Copyright <?= date('Y') ?> <em><?= bloginfo('name') ?></em> Pty Ltd. All rights reserved.</li>
          <li class="brightlabs align-right">Website designed &amp; developed by <a href="https://www.brightlabs.com.au/" class="fg-near-black wt-sb external" target="_blank" rel="noopener">Bright Labs</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
