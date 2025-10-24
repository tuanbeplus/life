<div id="mobile-menu" class="mobile-menu">
  <div class="inner">
    <form action="/" method="get" class="mobile-search-form">
      <div class="form-group placeholder-field">
        <label for="search-query">Search for...</label>
        <input id="search-query" type="text" name="s" class="no-bdr" required />
      </div>
      <button type="submit" class="icon" aria-label="Search"><?= life_icon('search') ?></button>
    </form>
    <?php if ($nav_items = life_nav_items('primary')): ?>
      <nav class="primary-nav">
        <ul>
          <?php foreach ($nav_items as $item): ?>
            <li class="<?= ($item->childItems) ? ' has-children' : '' ?>">
              <?php if ($item->childItems): ?>
                <span class="<?= implode(' ', $item->classes) ?>">
                  <?= apply_filters('the_brand', $item->title) ?>
                  <?= ($item->childItems) ? life_icon('chevron-down') : '' ?>
                </span>
                <ul class="submenu">
                  <?php foreach ($item->childItems as $child_item): ?>
                    <li class="<?= implode(' ', $child_item->classes) ?>">
                      <a href="<?= $child_item->url ?>">
                        <?= apply_filters('the_brand', $child_item->title) ?>
                      </a>
                    </li>
                  <?php endforeach ?>
                </ul>
              <?php else: ?>
                <a href="<?= $item->url ?>" class="<?= implode(' ', $item->classes) ?>">
                  <?= apply_filters('the_brand', $item->title) ?>
                </a>
              <?php endif ?>
            </li>
          <?php endforeach ?>
        </ul>
      </nav>
    <?php endif ?>
    <nav class="secondary-nav">
      <ul>
        <?php if ($nav_items = life_nav_items('upper')): ?>
          <?php foreach ($nav_items as $item): ?>
            <li>
              <a
                href="<?= $item->url ?>"
                class="<?= implode(' ', $item->classes) ?>"
              ><?= apply_filters('the_brand', $item->title) ?></a>
            </li>
          <?php endforeach ?>
        <?php endif ?>
      </ul>
    </nav>
    <div class="contact">
      <ul class="wt-sb">
        <li><a href="tel:137475" class="fg-primary risk-13-wcag">13 RISK</a></li>
        <li><a href="tel:137475" class="fg-near-black">13 74 75</a></li>
      </ul>
    </div>
    <div class="-primary-nav-buttons">
      <?php if ($nav_items = life_nav_items('primary-buttons')): ?>
        <nav class="-primary-nav-buttons">
          <?php foreach ($nav_items as $item): ?>
            <div class="-item">
              <a
                href="<?= $item->url ?>"
                class="<?= implode(' ', $item->classes) ?>"
              >
                <?= apply_filters('the_brand', $item->title) ?>
              </a>
            </div>
          <?php endforeach ?>
        </nav>
      <?php endif ?>
    </div>
    <div class="dismiss-menu">
      <button type="button" class="icon" data-toggle-class="visible" data-toggle-target="#mobile-menu" aria-label="Open mobile menu"><?= life_icon('times') ?></button>
    </div>
  </div>
</div>
