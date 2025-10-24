<?php if ( get_field('footer_newsletter_link', get_option('page_on_front')) ): ?>
  <section id="newsletter-signup" class="bg-orange" data-scroll-trigger>
    <div class="center-frame">
      <div class="main">
        <div class="message font-md wt-bold lh-std">
          <p>Kick start your healthy living journey with articles and recipes from the <em>Life!</em> Program in our Health Hub</p>
        </div>
        <div class="newsletter-cta">
          <div class="form-group submit">
            <a
              href="<?= get_field('footer_newsletter_link', get_option('page_on_front')) ?>"
              class="button black block"
            >Check Out The Health Hub</a>
          </div>
        </div>
      </div>
      <div class="background">
        <img
          class="footer__newsletter-img"
          src="<?= get_template_directory_uri() ?>/images/backgrounds/newsletter.png"
          loading="lazy"
          decoding="async"
          title="Subscribe to our newsletter"
          alt="Subscribe to our newsletter"
        />
      </div>
    </div>
  </section>
<?php endif ?>
