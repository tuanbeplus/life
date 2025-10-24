<?php
/**
 * Template Name: Life! program results
 */

setup_postdata($post);

get_header(null, ['bodyClass' => 'template-life-program-results']);

echoTemplate('hero-banner/hero-banner-sml');

echoTemplate('widget/breadcrumbs');

echoTemplate('life-program-results/section-coloured-popouts');


echoTemplate('life-program-results/single-accordion', [
  'section' => get_field('evaluation_section'),
]);

?>

<?php
get_footer();