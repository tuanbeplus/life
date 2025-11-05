
        <?= (defined('FOOTER_CTA_BANNER_2024') && FOOTER_CTA_BANNER_2024) ? incTemplate('footer/footer-cta-banner') : incTemplate('block-newsletter-signup') ?>
        <?= incTemplate('footer/page-footer') ?>
        <health-check
          default-lang="<?= pageLang()->lang ?>"
          template-directory-uri="<?= get_template_directory_uri() ?>"
        ></health-check>
        <?php if (pageIsPcos()): ?>
          <contact-modal-pcos></contact-modal-pcos>
        <?php elseif (pageIsGestational()): ?>
          <contact-modal-gestational
            class="-gestational"
            lang="<?= pageLang()->lang === 'vi' ? 'vi' : 'en' ?>"
          ></contact-modal-gestational>
        <?php else: ?>
          <health-check-trigger
            :translated-text="<?= vueProp(pageLang()->healthCheckTriggerProps()) ?>"
            lang="<?= pageLang()->lang ?>"
          ></health-check-trigger>
        <?php endif ?>
        <?php if ($post->post_name === 'get-involved'): ?>
          <contact-modal-facilitator-eoi></contact-modal-facilitator-eoi>
        <?php elseif ($post->post_name === 'become-a-telephone-health-coach'): ?>
          <contact-modal-thc-eoi></contact-modal-thc-eoi>
        <?php elseif ($post->post_name === 'become_a_provider'): ?>
          <contact-modal-provider-signup-eoi></contact-modal-provider-signup-eoi>
        <?php elseif ($post->post_name === 'for-community-organisations-and-groups'): ?>
          <contact-modal-community-org-and-groups></contact-modal-community-org-and-groups>
        <?php elseif ($post->post_name === 'for-workplaces'): ?>
          <contact-modal-workplace></contact-modal-workplace>
        <?php endif ?>
      </div><!-- /#wrapper -->
    </div><!-- /#app -->
    <?php wp_footer() ?>
  </body>
</html>
