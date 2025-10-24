<?php if (get_field('slides')): ?>
  <section
    id="hero-feature"
    class="partials-feature-hero"
    data-scroll-trigger
  >
    <div
      class="slide-container inner"
      data-slideshow
      data-autochange-delay="12000"
    >
      <div
        class="slides"
        data-slides
      >
        <?php foreach (get_field('slides') as $idx => $slide): ?>
          <div class="slide<?= ($idx == 0) ? ' active' : '' ?>">
            <div class="center-frame">
              <div class="content">
                <?php if ($slide['headline']): ?>
                  <h1 class="font-huge fg-white wt-sb lh-tight">
                    <?= apply_filters('the_brand', esc_html($slide['headline'])) ?>
                  </h1>
                <?php endif ?>
                <?php if ($slide['content']): ?>
                  <div class="message fg-white lh-mder">
                    <?= apply_filters('the_content', $slide['content']) ?>
                  </div>
                <?php endif ?>
                <?php if ($slide['call_to_action_link']): ?>
                  <div class="cta">
                    <a
                      href="<?= $slide['call_to_action_link'] ?>"
                      class="button"
                    >
                      <?= apply_filters('the_brand', esc_html($slide['call_to_action_label'] ? $slide['call_to_action_label'] : 'Explore more')) ?>
                    </a>
                  </div>
                <?php endif ?>
              </div>
            </div>
            <div class="background tinted tint-black even-darker">
              <img
                src="<?= $slide['image']['url'] ?>"
                class="cover"
                alt=""
                role="presentation"
              />
            </div>
          </div>
        <?php endforeach ?>
      </div>
      <div class="pagination center-frame">
        <ul>
          <?php foreach (get_field('slides') as $idx => $slide): ?>
            <li
              class="<?= ($idx == 0) ? 'active' : '' ?>"
              data-page="<?= $idx + 1 ?>"
            ></li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
  </section>
<?php endif ?>
