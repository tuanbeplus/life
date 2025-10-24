<?php

class ServiceLocatorOptions
{
  public $suburbs = [
    '' => 'Any Suburb',
  ];
  public $types = [
    '' => 'All Service Types',
  ];
  public $postcodes = []; /* suburbVal => postcodes[] */
  
  public function __construct()
  {
    $all = new WP_Query([
      'post_type'      => 'page',
      'post_status'    => ['publish'],
      'order'          => 'DESC',
      'posts_per_page' => -1,
      'meta_query'     => array_merge([
        'relation' => 'AND',
        [
          'key' => '_wp_page_template',
          'value' => 'page-templates/service-display.php',
        ],
      ]),
    ]);
    while ( $all->have_posts() ) {
      $all->the_post();
      $suburbVal = get_field('location_suburb');
      if ($suburbVal) {
        $suburbVal = trim($suburbVal);
        $postcode = get_field('location_postcode');
        if (!isset($this->postcodes[$suburbVal])) {
          $this->postcodes[$suburbVal] = [];
        }
        if (!in_array($postcode, $this->postcodes[$suburbVal])) {
          $this->postcodes[$suburbVal][] = $postcode;
        }
      }
      $typeVal = get_field('location_type');
      if ($typeVal) {
        $typeVal = trim($typeVal);
        if ( ! isset($types[$typeVal]) ) {
          $this->types[$typeVal] = $typeVal;
        }
      }
      wp_reset_postdata();
    }
    foreach ($this->postcodes as $suburbVal => $postcodes) {
      $postcodesStr = implode(', ', $postcodes);
      $this->suburbs[$suburbVal] = "$suburbVal ($postcodesStr)";
    }
    asort($this->suburbs);
    asort($this->types);
  }
}



class ServiceLocatorFilter
{
  public $vars = [
    'suburb' => '',
    'type' => '',
  ];
  public $constraints = [
    ['key' => '_wp_page_template', 'value' => 'page-templates/service-display.php'],
  ];
  
  public function __construct($suburbs, $types)
  {
    $gSuburb = self::param('suburb');
    $gType = self::param('type');
    
    $suburb = $gSuburb ? ($suburbs[$gSuburb] ?? null) : null;
    $type = $gType ? ($types[$gType] ?? null) : null;
    
    if ($suburb) {
      $this->vars['suburb'] = sanitize_text_field($gSuburb);
      $this->constraints[] = ['key' => 'location_suburb', 'value' => $this->vars['suburb']];
    }
    
    if ($type) {
      if ($suburb) {
        $this->vars['type'] = sanitize_text_field($gType);
        $this->constraints[] = ['key' => 'location_type', 'value' => $this->vars['type']];
      } else {
        $this->vars['type'] = 'Online Service';
        $this->constraints[] = ['key' => 'location_type', 'value' => 'Online Service'];
      }
    }
  }
  
  private static function param($key)
  {
    $val = $_GET[$key] ?? null;
    return $val ? trim($val) : null;
  }
}


class ServiceLocatorPagination
{
  public $pages;
  public $pageNumbers;
  public $qStr;
  
  public function __construct($page, $pages, $vars)
  {
    $this->pages = $pages;
    $this->qStr = '&'.http_build_query($vars);
    
    $page_range = 3;
    $page_divisions = 4;
    $division_size = $pages / $page_divisions;

    $this->pageNumbers = [1, $page, max(1, $pages)];

    for ( $x = max(1, $page - $page_range); $x <= min($pages, $page + $page_range); $x++ ) {
      $this->pageNumbers[] = $x;
    }

    for ( $x = 1; $x < $page_divisions; $x++ ) {
      $page_number = round($division_size * $x);
      if ( $page_number > 0 ) {
        $this->pageNumbers[] = $page_number;
      }
    }

    $this->pageNumbers = array_unique($this->pageNumbers);
    sort($this->pageNumbers);
  }
}