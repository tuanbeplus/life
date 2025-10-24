<?php

setup_postdata($post);

get_header(null, ['no_hero' => true, 'bodyClass' => 'template-search']);

echoTemplate('hero-banner/hero-banner-sml', ['title' => 'Search Results']);

echoTemplate('widget/breadcrumbs');

echoTemplate('section-search-results');

get_footer();
