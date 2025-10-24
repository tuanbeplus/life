<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage life
 * @since life 1.0
 */

 get_header(null, ['bodyClass' => 'template-index']);
 ?>


<?php get_sidebar('primary') ?>
  <div id="primary">
    <div class="inner formatted">
    </div>
  </div>
<?php get_footer();
