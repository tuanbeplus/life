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
$pre_lead_data = \SfFuncs\getLeadById($_GET['lead_id'] ?? '') ?? [];

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
    <section class="health-check-section center-frame">
        <div class="container">
            <div class="sidebar">
                <!-- Get Started Section -->
                <div class="get-started-section">
                    <div class="languages field">
                        <h3 class="field-label"><?php echo get_cald_text('choose_language', 'Choose language'); ?></h3>
                        <p class="field-label mobile"><?php echo get_cald_text('choose_language', 'Choose language'); ?></p>
                        <ul class="language-list field-list">
                        <?php 
                        $current_path_clean = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
                        foreach ($languages as $index => $item): 
                            $item_url = $item['url'] ?? '#';
                            $item_path = ($item_url !== '#') ? wp_make_link_relative($item_url) : '#';
                            // Remove trailing slashes and query strings for consistent comparison
                            $item_path_clean = rtrim(strtok($item_path, '?'), '/');
                            $is_current = ($current_path_clean === $item_path_clean || ($item_url === '#' && $index === 0));
                        ?>
                            <li class="language-item">
                                <a href="<?php echo esc_url($item_url); ?>" 
                                   class="language-link <?php echo $is_current ? 'active' : ''; ?>"
                                   <?php echo $is_current ? 'aria-current="page"' : ''; ?>>
                                    <?php echo esc_html($item['text'] ?? ''); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <!-- Progress Checklist Section -->
                <div class="progress-checklist field">
                    <h3 class="field-label"><?php echo get_cald_text('progress_heading', 'Progress'); ?></h3>
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
            <div class="hc-form-wrapper">
                <div class="non_vic_postcodes-block" style="display:none;">
                    <input id="non_vic_postcodes_json" type="hidden" value="<?php echo esc_attr( $non_vic_postcodes ); ?>">
                    <input id="pre_lead_data" type="hidden" value="<?php echo esc_attr( json_encode($pre_lead_data) ); ?>">
                </div>
                <div id="loading-spinner">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 1-10 10" fill="none" stroke="#8dc63f" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <?php echo do_shortcode( '[gravityform id="' . esc_attr($gravity_form_id) . '" title="false" description="false" ajax="true"]' ); ?>
                <?php if(!empty($pre_lead_data) && $pre_lead_data['Status'] == 'No EOI') : ?>
                    <div data-form-theme="gravity-theme" class="gform_confirmation_wrapper gravity-theme gform-theme--no-framework life-health-check-form">
                        <div class="gform_confirmation_message gform_confirmation_message">
                            <?php 
                                $lead_email = $pre_lead_data['Email'] ?? '';
                                $lead_score = $pre_lead_data['AUSDRISK_Score__c'] ?? '';
                                $latest_entry = hc_get_latest_gform_entry_by_email($gravity_form_id, $lead_email, 'email');
                                $eligible_content = do_shortcode('[hc_ausdrisk_result_eligible]'); 
                                echo str_replace('[ausdrisk_score]', $lead_score, $eligible_content);
                            ?>
                            <input id="ausdrisk-tracking-result" type="hidden" value="eligible" />
                            <input id="input-ausdrisk-score" type="hidden" value="<?php echo $lead_score; ?>">
                            <input id="input-ausdrisk-user-email" type="hidden" value="<?php echo $lead_email; ?>">
                            <input id="input-ausdrisk-phone-gfield-id" type="hidden" value="<?php echo hc_get_gform_field_id_by_css_class($gravity_form_id, 'phone'); ?>">
                            <input id="input-ausdrisk-result-gfield-id" type="hidden" value="<?php echo hc_get_gform_field_id_by_css_class($gravity_form_id, 'AUSDRISK_Results_Eligible'); ?>">
                            <input id="input-ausdrisk-result" type="hidden" value="EOI received">
                            <input id="input-ausdrisk-entry-id" type="hidden" value="<?php echo $latest_entry['id'] ?? 0; ?>">
                        </div>
                    </div>
                <?php endif; ?>
                <div id="thank-you" style="display: none;">
                    <div class="thank-you-message">
                        <hr />
                        <?php 
                        $thank_you_message = get_field('thank_you_message', get_the_ID());
                        if (!empty($thank_you_message)) {
                            echo wpautop($thank_you_message);
                        }
                        ?>
                    </div>
                </div>
                <div class="share-wrapper">
                    <inline-dialog-share></inline-dialog-share>
                </div>
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
