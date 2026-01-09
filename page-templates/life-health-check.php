<?php
/**
 * Template Name: Life! Health Check
 */

setup_postdata($post);
$page_lang = pageLang()->lang ?? 'en';
get_header(null, ['bodyClass' => 'life-health-check ' . $page_lang ]);
$description = get_field('lhc_desc', 'option');
$languages = get_field('lhc_languages', 'option');
$non_vic_postcodes = get_field('non_vic_postcodes', 'option'); 
$share_url = get_permalink();

// Get CALD languages and gravity form ID
$cald_languages = get_field('cald_languages', get_the_ID());
$gravity_form_id = get_field('gravity_form_id', get_the_ID()) ?: 2;

// Helper function to get CALD text with fallback
function get_cald_text($key, $default = '') {
    global $cald_languages;
    if (empty($cald_languages)) return $default;
    $keys = explode('.', $key);
    $value = $cald_languages;
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default;
        }
    }
    return apply_filters('the_brand', $value) ?: apply_filters('the_brand', $default); 
}
?>
<div class="page">
    <?php echoTemplate('hero-banner/hero-banner-sml'); ?>
    <?php echoTemplate('widget/breadcrumbs'); ?>
    <section class="ss-health-check center-frame">
        <div class="container">
            <div class="sidebar">
                <!-- Get Started Section -->
                <div class="get-started-section">
                    <h2 class="heading"><?php echo get_cald_text('main_heading.get_started', 'Get started'); ?></h2>
                    <?php if (!empty($description)): ?>
                        <p class="desc"><?php echo get_cald_text('description', $description); ?></p>
                    <?php endif; ?>
                    <div class="languages field">
                        <p class="field-label"><?php echo get_cald_text('choose_language', 'Choose language'); ?></p>
                        <p class="field-label mobile"><?php echo get_cald_text('choose_language', 'Choose language'); ?></p>
                        <ul class="language-list field-list">
                        <?php 
                        $current_url = $_SERVER['REQUEST_URI'];
                        foreach ($languages as $index => $item): 
                            $item_url = esc_url($item['url'] ?? '#');
                            $is_current = ($current_url === $item_url || ($item_url === '#' && $index === 0));
                        ?>
                            <li class="language-item">
                                <a href="<?php echo $item_url; ?>" 
                                   class="language-link <?php echo $is_current ? 'active' : ''; ?>"
                                   <?php echo $is_current ? 'aria-current="page"' : ''; ?>>
                                    <?php echo $item['text'] ?? ''; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <!-- Progress Checklist Section -->
                <div class="progress-checklist field">
                    <p class="field-label mobile"><?php echo get_cald_text('progress_heading', 'Progress'); ?></p>
                    <ul class="progress-steps field-list">
                        <li class="progress-step intro">
                            <span class="step-text"><?php echo get_cald_text('introduction', 'Introduction'); ?></span>
                        </li>
                        <li class="progress-step details">
                            <span class="step-text"><?php echo get_cald_text('your_details', 'Your details'); ?></span>
                        </li>
                        <li class="progress-step questions">
                            <span class="step-text"><?php echo get_cald_text('life_health_check_questions', 'Life! health check questions'); ?></span>
                        </li>
                        <li class="progress-step results">
                            <span class="step-text"><?php echo get_cald_text('results', 'Results'); ?></span>
                        </li>
                    </ul>
                </div>
                <!-- Contact Information Section -->
                <div class="get-in-touch field">
                    <p class="contact-text"><?php echo get_cald_text('contact_copy', 'Need help? Call our friendly team on'); ?></p>
                    <a href="tel:137475" class="phone-number"><span class="phone-digits risk-13-wcag">13 74 75</span></a>
                </div>
            </div>
            <div class="form-wrapper">
                <div class="non_vic_postcodes-block" style="display:none;">
                    <input id="lhc_user_email" type="hidden" value="">
                    <input id="non_vic_postcodes_json" type="hidden" value="<?php echo esc_attr( $non_vic_postcodes ); ?>">
                </div>
                <?php echo do_shortcode( '[gravityform id="' . esc_attr($gravity_form_id) . '" title="false" description="false" ajax="true"]' ); ?>
                <div class="share-wrapper"><inline-dialog-share></inline-dialog-share></div>
            </div>
        </div>
    </section>
</div>

<inline-dialog-share-modal
  :eyebrow-text="<?= vueProp(get_field('eyebrow_text', 'option')) ?>"
  :large-heading="<?= vueProp(get_field('large_heading', 'option')) ?>"
  :body-content="<?= vueProp(get_field('body_content', 'option')) ?>"
  :pre-buttons-text="<?= vueProp(get_field('pre_buttons_text', 'option')) ?>"
  :buttons="<?= vueProp([
    [
      'icon' => 'copy',
      'text' => 'Share via link',
      'copyToClipboard' => $share_url,
    ],
    [
      'icon' => 'email',
      'text' => 'Email',
      'href' => 'mailto:?body='.urlencode($share_url),
    ],
    [
      'icon' => 'fb',
      'text' => 'Share on Facebook',
      'href' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($share_url),
    ],
    [
      'icon' => 'whatsapp',
      'text' => 'Share via WhatsApp',
      'href' => 'https://web.whatsapp.com/',
    ],
  ]) ?>"
></inline-dialog-share-modal>

<?php
get_footer();
