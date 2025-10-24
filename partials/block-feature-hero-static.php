<section
  id="hero-feature"
  class="feature-hero-static"
>
  <div
    class="slide-container inner"
  >
    <div
      class="slides"
    >
      <?php if (count($slides)): $slide = $slides[0] ?>
        <div class="slide active">
          <div class="center-frame-wide">
            <div class="content">
              <?php if ( $slide['headline'] ): ?>
                <h1 class="font-huge wt-sb lh-tight">
                  <?= apply_filters('the_brand', esc_html($slide['headline'])) ?>
                </h1>
              <?php endif ?>
              <?php if ( $slide['content'] ): ?>
                <div class="message lh-mder">
                  <?= apply_filters('the_content', $slide['content']) ?>
                </div>
              <?php endif ?>
              <div class="cta">
                <a href="#health-check" class="button -padx-tiny">Take the QUICK health check</a>
                <?php if ( $slide['call_to_action_link'] ): ?>
                  <a
                    href="<?= $slide['call_to_action_link'] ?>"
                    class="button -white -padx-sml"
                  >
                    <?= apply_filters('the_brand', esc_html($slide['call_to_action_label'] ? $slide['call_to_action_label'] : 'Explore more')) ?>
                  </a>
                <?php endif ?>
              </div>
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
      <?php endif ?>
    </div>
  </div>
  <svg-edge-curve-1></svg-edge-curve-1>
</section>
