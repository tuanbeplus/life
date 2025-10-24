<?php

function contentBannerProps($atts) {
    $slug = $atts['slug'] ?? null;
    if ($slug === null) {
        throw new Exception("Shortcode is missing a slug<br>Example center-quote shortcode:<code style=\"font-size: 16px;padding: 0 15px\">[banner slug=\"cq-foobar\"]</code>");
    }
    $slugSplit = explode('-', $slug);
    if (count($slugSplit) < 2) {
        throw new Exception("Invalid slug format<br>Slugs need a 2-letter prefix. Eg. 'cq-...' or 'hi-...'");
    }
    $templateAbbrv = array_shift($slugSplit);

    switch ($templateAbbrv) {
        case 'cq':
            return [
                'id' => implode('-', $slugSplit),
                'title' => 'Centered quote',
                'template' => 'centered-quote',
                'acfOptionName' => 'centered_quote',
                'vars' => [
                    [
                        'name' => 'eyebrow_heading',
                        'italizeLife' => true,
                    ],
                    [
                        'name' => 'large_quote',
                        'italizeLife' => true,
                    ],
                    [
                        'name' => 'attribution',
                        'italizeLife' => true,
                    ],
                    [
                        'name' => 'link_text',
                        'italizeLife' => true,
                    ],
                    [
                        'name' => 'link_url',
                    ],
                    [
                        'name' => 'button_text',
                        'italizeLife' => true,
                    ],
                    [
                        'name' => 'button_url',
                    ],
                ],
            ];
        case 'hi':
            return [
                'id' => implode('-', $slugSplit),
                'title' => 'Half image',
                'template' => 'half-image',
                'acfOptionName' => 'half_image',
                'vars' => [
                    [
                        'name' => 'eyebrow_heading',
                        'italizeLife' => true,
                    ],
                    [
                        'name' => 'large_heading',
                        'italizeLife' => true,
                    ],
                    [
                        'name' => 'button_text',
                        'italizeLife' => true,
                    ],
                    [
                        'name' => 'button_url',
                    ],
                    [
                        'name' => 'image',
                    ],
                ],
            ];
    }
    throw new Exception("invalid slug prefix: <code>$templateAbbrv</code><br>");
}


