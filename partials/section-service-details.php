<?php
$sidebar_blocks = get_field('sidebar_blocks');

$contact_info = [];
if (get_field('location_type') == 'Online Service') {
  $website = get_field('website');
  $contact_info[] = [
    'title' => 'Website',
    'info' => [
      [
        'text' => $website,
        'url' => $website,
      ],
    ],
  ];
} else {
  $contact_info[] = [
    'title' => 'Address',
    'info' => [
      [
        'text' => get_field('location_address'),
      ],
      [
        'text' => implode(', ', [
          get_field('location_suburb'),
          get_field('location_state'),
          get_field('location_postcode'),
        ]),
      ],
    ],
  ];
}
if ($phone = get_field('location_contact_phone')) {
  $contact_info[] = [
    'title' => 'Phone',
    'info' => [
      [
        'text' => $phone,
        'url' => 'tel:' . $phone,
      ],
    ],
  ];
}
if ($email = get_field('location_contact_email')) {
  $contact_info[] = [
    'title' => 'Email',
    'info' => [
      [
        'text' => $email,
        'url' => 'mailto:' . $email,
      ],
    ],
  ];
}
if ($logo = get_field('location_logo')) {
  $contact_info[] = [
    [
      'image' => [
        'src' => $logo,
        'alt' => get_the_title(),
      ],
    ],
  ];
}

?>
<section class="content bg-white padded">
  <div class="center-frame">
    <div class="location-wrapper">
      <div class="location-description">
        <div class="formatted main-content">
          <h3>Description</h3>
          <?= apply_filters('the_content', get_the_content()) ?>
        </div>
      </div>
      <div class="location-contact">
        <?php foreach ($contact_info as $i => $info): ?>
          <?php if ($i > 0): ?><hr /><?php endif ?>
          <div class="-item">
            <?php if (isset($info['title'])): ?>
              <h4><?= $info['title'] ?></h4>
            <?php endif ?>
            <?php if (isset($info['info'])): ?>
              <div class="-info">
                <?php foreach ($info['info'] as $info_item): ?>
                  <p>
                    <?php if (isset($info_item['url'])): ?><a href="<?= $info_item['url'] ?>"><?php endif ?>
                      <?= $info_item['text'] ?>
                    <?php if (isset($info_item['url'])): ?></a><?php endif ?>
                  </p>
                <?php endforeach ?>
              </div>
            <?php endif ?>
            <?php if (isset($info['image'])): ?>
              <img src="<?= $info['image']['src'] ?>" alt="<?= $info['image']['alt'] ?>" />
            <?php endif ?>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</section>
