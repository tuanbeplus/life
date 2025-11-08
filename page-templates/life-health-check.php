<?php
/**
 * Template Name: Life! Health Check
 */

setup_postdata($post);
get_header(null, ['bodyClass' => 'life-health-check']);
$description = get_field('lhc_desc', 'option');
$languages = get_field('lhc_languages', 'option');
$non_vic_postcodes = get_field('non_vic_postcodes', 'option');
$share_url = get_permalink();
?>
<div class="page">
    <section class="ss-hero">
        <?php echo the_post_thumbnail( 'full' ); ?>
        <div class="page-tilte center-frame">
            <?php
            $the_title = get_the_title();
            if (strpos($the_title, 'Life!') !== false) {
                // Replace 'Life!' with <em>Life!</em>
                $the_title_em = str_replace('Life!', '<em>Life!</em>', $the_title);
                echo "<h1>{$the_title_em}</h1>";
            } else {
                echo "<h1>{$the_title}</h1>";
            }
            ?>
        </div>
    </section>
    <section class="ss-health-check center-frame">
        <?php echo life_breadcrumbs(); ?>
        <div class="container">
            <div class="sidebar">
                <!-- Get Started Section -->
                <div class="get-started-section">
                    <h2 class="heading">Get started</h2>
                    <?php if (!empty($description)): ?>
                        <p class="desc"><?php echo $description ?></p>
                    <?php endif; ?>
                    
                    <div class="languages field">
                        <p class="field-label">Choose language</p>
                        <p class="field-label mobile">Choose language</p>
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
                    <p class="field-label mobile">Progress</p>
                    <ul class="progress-steps field-list">
                        <li class="progress-step intro">
                            <span class="step-text">Introduction</span>
                        </li>
                        <li class="progress-step details">
                            <span class="step-text">Your details</span>
                        </li>
                        <li class="progress-step questions">
                            <span class="step-text"><em>Life!</em> Health Check questions</span>
                        </li>
                        <li class="progress-step results">
                            <span class="step-text">Results</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Information Section -->
                <div class="get-in-touch field">
                    <p class="contact-text">Need help? Call our friendly team on</p>
                    <a href="tel:13137475" class="phone-number"><span class="phone-digits risk-13-wcag">13 RISK </span>(13 74 75)</a>
                </div>
            </div>
            <div class="form-wrapper">
                <div class="non_vic_postcodes-block" style="display:none;">
                    <input id="lhc_user_email" type="hidden" value="tom@ysnstudios.com">
                    <input id="non_vic_postcodes_json" type="hidden" value="<?php echo esc_attr( $non_vic_postcodes ); ?>">
                </div>
                <?php echo do_shortcode( '[gravityform id="2" title="false" description="false" ajax="true"]' ); ?>
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
