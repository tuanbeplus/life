<div class="modal-trigger-buttons">
  <a
    class="button black"
    href="#health-check"
  >
    <span>Start your free online health check</span>
  </a>
  <?php if (false): ?>
    <div
      class="button hollow-orange"
      data-dialog-open="share-<?= $dialogId ?>"
    >
      <?= life_icon('icon-upload') ?>
      <span>Share health check with a friend or family</span>
    </div>
  <?php endif ?>
  <inline-dialog-share></inline-dialog-share>
</div>
<?php $shareUrl = home_url('/').'#health-check' ?>
<inline-dialog-share-modal
  :eyebrow-text="<?= vueProp(get_field('eyebrow_text', 'option')) ?>"
  :large-heading="<?= vueProp(get_field('large_heading', 'option')) ?>"
  :body-content="<?= vueProp(get_field('body_content', 'option')) ?>"
  :pre-buttons-text="<?= vueProp(get_field('pre_buttons_text', 'option')) ?>"
  :buttons="<?= vueProp([
    [
      'icon' => 'copy',
      'text' => 'Share via link',
      'copyToClipboard' => $shareUrl,
    ],
    [
      'icon' => 'email',
      'text' => 'Email',
      'href' => 'mailto:?body='.urlencode($shareUrl),
    ],
    [
      'icon' => 'fb',
      'text' => 'Share on Facebook',
      'href' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($shareUrl),
    ],
    [
      'icon' => 'whatsapp',
      'text' => 'Share via WhatsApp',
      'href' => 'https://web.whatsapp.com/',
    ],
  ]) ?>"
></inline-dialog-share-modal>