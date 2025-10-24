<section
  class="block-testimonials container bg-<?= ($scheme ?? null) ? $scheme : 'off-white' ?> curve-top"
  data-scroll-trigger
>
  <svg-edge-curve-3></svg-edge-curve-3>
  <div class="center-frame">
    <testimonials-slideshow
      :slides="<?= vueProp($testimonials) ?>"
    >
      <?php foreach ($testimonials as $idx => $testimonial): ?>
        <template #slide-<?= $idx ?>>
          <?= incTemplate('testimonials/testimonial', [
            'testimonial' => $testimonial,
            'idx' => $idx,
          ]) ?>
        </template>
      <?php endforeach ?>
    </testimonials-slideshow>
    <?php if (count($testimonials) > 1): ?>
      <div class="pagination">
        <ul>
          <?php foreach ($testimonials as $idx => $testimonial): ?>
            <li data-page="<?= $idx + 1 ?>"></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif ?>
  </div>
</section>
