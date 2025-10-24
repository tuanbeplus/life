<header
  class="top-nav"
  id="top-nav"
>
  <div class="-upper">
    <?php if ($nav_items = life_nav_items('upper')): ?>
      <nav class="-items" aria-label="Site Navigation top bar">
        <?php foreach ($nav_items as $item): ?>
          <a
            href="<?= $item->url ?>"
            class="<?= implode(' ', $item->classes) ?>"
            <?= $item->target == '_blank'? 'target="_blank"' : '' ?>
          >
            <?= $item->title ?>
          </a>
        <?php endforeach ?>
      </nav>
    <?php endif ?>
    <a
      class="-phone"
      href="tel:137475"
    >
      <span>Call</span>
      <span class="-underline">13 74 75</span>
    </a>
    <a
      class="-life-online"
      href="https://my.lifeprogram.org.au/"
    >
      <?= life_icon('person') ?>
      <span><em>Life!</em> Online</span>
    </a>
    <div
      class="-lang-selector"
    >
      <top-nav-lang-selector
        view-type="desktop"
        text="<?= pageLang()->selected()->label ?>"
        :options="<?= vueProp(pageLang()->opts) ?>"
        :selected-i="<?= pageLang()->optI ?>"
      ></top-nav-lang-selector>
    </div>
  </div>
  <div class="-primary-bar">
    <div class="-left">
      <mobile-menu-toggler></mobile-menu-toggler>
      <a href="/" class="-logo">
        <span class="visually-hidden"><?= bloginfo('name') ?></span>
        <svg-logo-primary></svg-logo-primary>
      </a>
      <?php if ($nav_items = life_nav_items('primary')): ?>
        <nav class="-primary-nav" aria-label="Site Navigation primary">
          <?php foreach ($nav_items as $item): ?>
            <div class="-item">
              <a
                href="<?= $item->url ?>"
                class="<?= implode(' ', $item->classes) ?>"
              >
                <?= $item->title ?>
              </a>
              <?php if ($item->childItems): ?>
                <div class="-drop">
                  <div>
                    <div>
                      <?php foreach ($item->childItems as $child_item): ?>
                        <a
                          href="<?= $child_item->url ?>"
                          class="<?= implode(' ', $child_item->classes) ?>"
                        >
                          <?= $child_item->title ?>
                        </a>
                      <?php endforeach ?>
                    </div>
                  </div>
                </div>
              <?php endif ?>
            </div>
          <?php endforeach ?>
        </nav>
      <?php endif ?>
      <top-nav-lang-selector
        view-type="mobile"
        :options="<?= vueProp(pageLang()->opts) ?>"
        :selected-i="<?= pageLang()->optI ?>"
      ></top-nav-lang-selector>
    </div>
    <div class="-right">
      <top-nav-search-trigger></top-nav-search-trigger>
    </div>
  </div>
  <top-nav-search></top-nav-search>
</header>
<mobile-nav
  :links-primary="<?= vueProp(life_nav_items('primary', [])) ?>"
  :links-upper="<?= vueProp(life_nav_items('upper', [])) ?>"
  :links-primary-buttons="<?= vueProp(life_nav_items('primary-buttons', [])) ?>"
>
  <?= incTemplate('top-nav/mobile-nav') ?>
</mobile-nav>
