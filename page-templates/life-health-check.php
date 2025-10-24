<?php
/**
 * Template Name: Life! Health Check
 */

setup_postdata($post);
get_header(null, ['bodyClass' => 'life-health-check']);
$description = get_field('lhc_desc', 'option');
$languages = get_field('lhc_languages', 'option');
$non_vic_postcodes = get_field('non_vic_postcodes', 'option');
?>
<div class="page">
    <section class="ss-hero">
        <?php echo the_post_thumbnail( 'full' ); ?>
        <div class="page-tilte center-frame">
            <h1><?php the_title(); ?></h1>
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
                        <p class="language-label">Choose language:</p>
                        <ul class="language-list">
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
                    <ul class="progress-steps">
                        <li class="progress-step intro">
                            <span class="step-text">Intro</span>
                        </li>
                        <li class="progress-step details">
                            <span class="step-text">Your details</span>
                        </li>
                        <li class="progress-step questions">
                            <span class="step-text">Life! Health Check questions</span>
                        </li>
                        <li class="progress-step results">
                            <span class="step-text">Results</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Information Section -->
                <div class="get-in-touch field">
                    <p class="contact-text">Get in touch with our helpful team today on our infoline</p>
                    <a href="tel:13137475" class="phone-number"><span class="phone-digits risk-13-wcag">13 RISK </span>13 74 75</a>
                </div>
            </div>
            <div class="form-wrapper">
                <div class="non_vic_postcodes-block" style="display:none;">
                    <input id="non_vic_postcodes_json" type="hidden" value="<?php echo esc_attr( $non_vic_postcodes ); ?>">
                </div>
                <?php echo do_shortcode( '[gravityform id="2" title="false" description="false" ajax="true"]' ); ?>
            </div>
        </div>
    </section>
</div>

<?php

get_footer();
